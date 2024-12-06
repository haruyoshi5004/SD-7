import cv2
from flask import Flask, render_template, Response, jsonify
import time
import threading

app = Flask(__name__, template_folder=r'C:\xampp\htdocs\SD-7\cam_k\template\my_templates', static_folder=r'C:\xampp\htdocs\SD-7\cam_k\template\static')

#商品数を初期化（商品A～Iまでの数を設定）
product_counts = [10] * 9 

#カメラデバイスの初期化
camera = None
is_camera_active = False
lock = threading.Lock()

#手検出のクールダウン時間 (秒)
cooldown_time = 2
last_detection_time = time.time()

#フレーム生成スレッドの停止
stop_thread = threading.Event()

#枠の設定
frame_width, frame_height = 640, 480  #デフォルトのフレームサイズ
rows, cols = 3, 3  #バウンディングボックスの行数と列数
box_width = frame_width // cols
box_height = frame_height // rows

def initialize_camera():
    """カメラを初期化してアクティブにする"""
    global camera, is_camera_active, frame_width, frame_height, box_width, box_height
    with lock:
        if not is_camera_active:
            camera = cv2.VideoCapture(1)
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


def generate_frames():
    """カメラフレームを生成するジェネレータ"""
    global product_counts, last_detection_time

    # 各列の幅を設定 (非等間隔: 左が狭く右が広い)
    column_widths = [int(frame_width * 0.2), int(frame_width * 0.3), int(frame_width * 0.5)]
    column_positions = [0, column_widths[0], column_widths[0] + column_widths[1]]

    # 各列の高さを設定
    box_height_left = int(frame_height * 0.31)
    box_height_right = int(frame_height * 0.35)
    box_height_middle = frame_height - box_height_left - box_height_right

    while not stop_thread.is_set():
        with lock:
            if not camera or not camera.isOpened():
                break
            success, frame = camera.read()
            if not success:
                break
            else:
                current_time = time.time()

                largest_area = 0
                largest_box_index = -1

                # バウンディングボックスを生成して描画
                for row in range(rows):
                    for col in range(cols):
                        # 各列の高さを設定
                        if col == 0:
                            box_height = box_height_left
                        elif col == 2:
                            box_height = box_height_right
                        else:
                            box_height = box_height_middle

                        x1 = column_positions[col]
                        x2 = x1 + column_widths[col]
                        y1 = row * box_height
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
                        if col == 0:
                            box_height = box_height_left
                        elif col == 2:
                            box_height = box_height_right
                        else:
                            box_height = box_height_middle

                        x1 = column_positions[col]
                        x2 = x1 + column_widths[col]
                        y1 = row * box_height
                        y2 = y1 + box_height

                        # 枠の描画色を設定
                        box_index = row * cols + col
                        if box_index == largest_box_index:
                            color = (0, 255, 0)  # 緑
                            # 最大枠の商品数を減らす
                            if current_time - last_detection_time > cooldown_time:
                                if product_counts[largest_box_index] > 0:
                                    product_counts[largest_box_index] -= 1
                                    last_detection_time = current_time
                                    print(f"商品{largest_box_index + 1}数: {product_counts[largest_box_index]}")
                        else:
                            color = (255, 0, 0)  # 青

                        cv2.rectangle(frame, (x1, y1), (x2, y2), color, 2)

                # フレームをエンコードして生成
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
    return render_template('カメラ画面.php')


@app.route('/')
def home():
    """ホーム画面を表示"""
    release_camera()  # ホームに移動時にカメラを停止
    return render_template('ホーム.html')  # 別のページを表示


if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
