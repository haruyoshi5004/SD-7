import cv2
from flask import Flask, render_template, Response, jsonify, request
import time
import threading
import subprocess

app = Flask(__name__, template_folder=r'C:\xampp\htdocs\SD-7\cam_k\template\my_templates', static_folder=r'C:\xampp\htdocs\SD-7\cam_k\template\static')

@app.route('/run_php')
def run_php():
    try:
        result = subprocess.run(['php', 'insert_camera_ids.php'], capture_output=True, text=True)
        if result.returncode == 0:
            return result.stdout
        else:
            return f"Error: {result.stderr}", 500
    except Exception as e:
        return str(e), 500

# カメラの数を取得
num_cameras = 2  # 例として2台のカメラを使用

for i in range(num_cameras):
    cap = cv2.VideoCapture(i)
    if not cap.isOpened():
        print(f"カメラ {i} が開けません")
    else:
        print(f"カメラ {i} が認識されました")
    cap.release()

# 商品数を初期化（カメラごとに異なる商品リストを設定）
product_counts = {}

# カメラデバイスの初期化
cameras = {}
is_camera_active = {}
lock = threading.Lock()

# 手検出のクールダウン時間 (秒)
cooldown_time = 2
last_detection_time = time.time()

# フレーム生成スレッドの停止
stop_thread = threading.Event()

# 枠の設定
frame_width, frame_height = 640, 480  # デフォルトのフレームサイズ
rows, cols = 3, 3  # バウンディングボックスの行数と列数
box_width = frame_width // cols
box_height = frame_height // rows

def initialize_camera(camera_id):
    """カメラを初期化してアクティブにする"""
    global cameras, is_camera_active, frame_width, frame_height
    with lock:
        if camera_id not in cameras:
            cameras[camera_id] = cv2.VideoCapture(camera_id)
            if not cameras[camera_id].isOpened():
                raise RuntimeError(f"カメラ{camera_id}を初期化できませんでした")
            is_camera_active[camera_id] = True
            frame_width = int(cameras[camera_id].get(cv2.CAP_PROP_FRAME_WIDTH))
            frame_height = int(cameras[camera_id].get(cv2.CAP_PROP_FRAME_HEIGHT))
            stop_thread.clear()
            product_counts[camera_id] = [10] * 9  # 各カメラに対して商品数を初期化

def release_camera(camera_id):
    """カメラをリリースする"""
    global cameras, is_camera_active
    with lock:
        if camera_id in cameras and is_camera_active[camera_id]:
            stop_thread.set()
            cameras[camera_id].release()
            del cameras[camera_id]
            is_camera_active[camera_id] = False

def detect_hand_area(frame, x1, y1, x2, y2):
    """指定したバウンディングボックス内の肌色面積を計算"""
    hsv = cv2.cvtColor(frame, cv2.COLOR_BGR2HSV)

    # 肌色範囲を定義
    lower_skin = (0, 30, 60)
    upper_skin = (25, 180, 255)

    # 指定した範囲をマスク
    box_mask = hsv[y1:y2, x1:x2]
    mask = cv2.inRange(box_mask, lower_skin, upper_skin)

    # 肌色ピクセル数を返す
    return cv2.countNonZero(mask)

def generate_frames(camera_id):
    """カメラフレームを生成するジェネレータ"""
    global product_counts, last_detection_time

    while not stop_thread.is_set():
        with lock:
            if camera_id not in cameras or not cameras[camera_id].isOpened():
                break
            success, frame = cameras[camera_id].read()
            if not success:
                break
            else:
                current_time = time.time()

                largest_area = 0
                largest_box_index = -1

                # バウンディングボックスを生成して描画
                for row in range(rows):
                    for col in range(cols):
                        x1 = col * box_width
                        y1 = row * box_height
                        x2 = x1 + box_width
                        y2 = y1 + box_height

                        # 肌色面積を計算
                        area = detect_hand_area(frame, x1, y1, x2, y2)

                        # 最大面積を記録
                        if area > largest_area:
                            largest_area = area
                            largest_box_index = row * cols + col

                # 各枠を描画（緑: 最大面積の枠、青: 他の枠）
                for row in range(rows):
                    for col in range(cols):
                        x1 = col * box_width
                        y1 = row * box_height
                        x2 = x1 + box_width
                        y2 = y1 + box_height

                        # 枠の描画色を設定
                        box_index = row * cols + col
                        if box_index == largest_box_index:
                            color = (0, 255, 0)  # 緑
                            # 最大枠の商品数を減らす
                            if current_time - last_detection_time > cooldown_time:
                                if product_counts[camera_id][largest_box_index] > 0:
                                    product_counts[camera_id][largest_box_index] -= 1
                                    last_detection_time = current_time
                                    print(f"カメラ{camera_id} - 商品{largest_box_index + 1}数: {product_counts[camera_id][largest_box_index]}")
                        else:
                            color = (255, 0, 0)  # 青

                        cv2.rectangle(frame, (x1, y1), (x2, y2), color, 2)

                # フレームをエンコードして生成
                ret, buffer = cv2.imencode('.jpg', frame)
                frame = buffer.tobytes()
                yield (b'--frame\r\n'b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n\r\n')

@app.route('/video_feed/<int:camera_id>')
def video_feed(camera_id):
    """ビデオストリームを返すエンドポイント"""
    if camera_id not in is_camera_active or not is_camera_active[camera_id]:
        return Response(status=403)
    return Response(generate_frames(camera_id), mimetype='multipart/x-mixed-replace; boundary=frame')

@app.route('/get_count/<int:camera_id>')
def get_count(camera_id):
    """商品数を取得するエンドポイント"""
    if camera_id in product_counts:
        return jsonify({"product_counts": product_counts[camera_id]})
    else:
        return jsonify({"error": "カメラIDが無効です"}), 400

@app.route('/camera_screen/<int:camera_id>')
def camera_screen(camera_id):
    """カメラ画面を表示"""
    initialize_camera(camera_id)  # カメラを起動
    return render_template('カメラ画面.php', camera_id=camera_id)

@app.route('/')
def home():
    """ホーム画面を表示"""
    for camera_id in list(cameras.keys()):
        release_camera(camera_id)  # ホームに移動時に全てのカメラを停止
    return render_template('home.html')

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
