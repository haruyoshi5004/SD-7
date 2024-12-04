import cv2
from flask import Flask, render_template, Response, jsonify
import time
import threading

app = Flask(__name__, template_folder=r'C:\template\my_templates', static_folder=r'C:\template\static')

# 商品数を初期化（商品A～Iまでの数を設定）
product_counts = [10] * 9 

# カメラデバイスの初期化
camera = None
is_camera_active = False
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

def initialize_camera():
    """カメラを初期化してアクティブにする"""
    global camera, is_camera_active, frame_width, frame_height, box_width, box_height
    with lock:
        if not is_camera_active:
            camera = cv2.VideoCapture(0)
            if not camera.isOpened():
                raise RuntimeError("カメラを初期化できませんでした")
            is_camera_active = True
            frame_width = int(camera.get(cv2.CAP_PROP_FRAME_WIDTH))
            frame_height = int(camera.get(cv2.CAP_PROP_FRAME_HEIGHT))
            box_width = frame_width // cols
            box_height = frame_height // rows
            stop_thread.clear()


def release_camera():
    """カメラをリリースする"""
    global camera, is_camera_active
    with lock:
        if camera and is_camera_active:
            stop_thread.set()
            camera.release()
            camera = None
            is_camera_active = False


def detect_hand(frame, x1, y1, x2, y2):
    """指定されたバウンディングボックス内で手を検出"""
    # フレームをHSVに変換して肌色検出
    hsv = cv2.cvtColor(frame, cv2.COLOR_BGR2HSV)

    # 日本人の肌色の範囲
    lower_skin = (0, 30, 60)  # 肌色の下限 (H:0, S:30, V:60)
    upper_skin = (25, 180, 255)  # 肌色の上限 (H:25, S:180, V:255)

    # 肌色範囲のマスクを作成
    mask = cv2.inRange(hsv, lower_skin, upper_skin)

    # マスクをバウンディングボックスの領域に限定
    box_mask = mask[y1:y2, x1:x2]

    # 輪郭を検出
    contours, _ = cv2.findContours(box_mask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

    for contour in contours:
        area = cv2.contourArea(contour)
        if 1200 < area < 6000:  # 面積（手の大きさに近いもの）
            return True  # 検出できた
    return False  # 検出できなかった


def generate_frames():
    """カメラフレームを生成するジェネレータ"""
    global product_counts, last_detection_time
    while not stop_thread.is_set():
        with lock:
            if not camera or not camera.isOpened():
                break
            success, frame = camera.read()
            if not success:
                break
            else:
                current_time = time.time()

                # バウンディングボックスを生成して描画
                for row in range(rows):
                    for col in range(cols):
                        x1 = col * box_width
                        y1 = row * box_height
                        x2 = x1 + box_width
                        y2 = y1 + box_height
                        cv2.rectangle(frame, (x1, y1), (x2, y2), (255, 0, 0), 2)

                        # 各バウンディングボックスで手を検出
                        if detect_hand(frame, x1, y1, x2, y2):
                            if current_time - last_detection_time > cooldown_time:
                                if product_counts[row * cols + col] > 0:
                                    product_counts[row * cols + col] -= 1
                                    last_detection_time = current_time
                                    print(f"商品{row * cols + col + 1}数: {product_counts[row * cols + col]}")
                ret, buffer = cv2.imencode('.jpg', frame)
                frame = buffer.tobytes()
                yield (b'--frame\r\n'b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n\r\n')


@app.route('/video_feed')
def video_feed():
    """ビデオストリームを返すエンドポイント"""
    if not is_camera_active:
        return Response(status=403)  # カメラがアクティブでない場合はストリームを返さない
    return Response(generate_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')


@app.route('/get_count')
def get_count():
    """商品数を取得するエンドポイント"""
    return jsonify({"product_counts": product_counts})


@app.route('/camera_screen')
def camera_screen():
    """カメラ画面を表示"""
    initialize_camera()  # カメラを起動
    return render_template('カメラ画面.html')


@app.route('/')
def home():
    """ホーム画面を表示"""
    release_camera()  # ホームに移動時にカメラを停止
    return render_template('ホーム.html')  # 別のページを表示


if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
