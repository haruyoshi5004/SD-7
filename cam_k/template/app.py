import cv2
from flask import Flask, render_template, Response, jsonify
import time
import threading


app = Flask(__name__, template_folder=r'C:\xampp\htdocs\SD-7\cam_k', static_folder=r'C:\template\static')



# 商品数を初期化
product_count = 10


# カメラデバイスの初期化
camera = None
is_camera_active = False
lock = threading.Lock()  # スレッドセーフ制御用ロック


# 手検出のクールダウン時間 (秒)
cooldown_time = 2
last_detection_time = 0  # 最後に検出された時間


# フレーム生成スレッドの停止フラグ
stop_thread = threading.Event()


# 枠の設定
frame_width, frame_height = 640, 480  # デフォルトのフレームサイズ
box_x1, box_y1, box_x2, box_y2 = (
    frame_width // 4, frame_height // 4,  # 左上の座標
    (frame_width * 3) // 4, (frame_height * 3) // 4  # 右下の座標
)


def initialize_camera():
    """
    カメラを初期化してアクティブにする
    """
    global camera, is_camera_active, frame_width, frame_height, box_x1, box_y1, box_x2, box_y2
    with lock:
        if not is_camera_active:
            camera = cv2.VideoCapture(1)  # デバイスID 1 のカメラを使用
            if not camera.isOpened():
                raise RuntimeError("カメラを初期化できませんでした")
            is_camera_active = True
            frame_width = int(camera.get(cv2.CAP_PROP_FRAME_WIDTH))
            frame_height = int(camera.get(cv2.CAP_PROP_FRAME_HEIGHT))
            box_x1, box_y1, box_x2, box_y2 = (
                frame_width // 4, frame_height // 4,
                (frame_width * 3) // 4, (frame_height * 3) // 4
            )
            stop_thread.clear()


def release_camera():
    """
    カメラを停止しリソースを解放する
    """
    global camera, is_camera_active
    with lock:
        if camera and is_camera_active:
            stop_thread.set()  # スレッド停止フラグをセット
            camera.release()
            camera = None
            is_camera_active = False


def detect_hand(frame):
    """
    フレーム内で手を検出する
    """
    # フレームをHSVに変換して肌色検出
    hsv = cv2.cvtColor(frame, cv2.COLOR_BGR2HSV)

    # 日本人の肌色に適した範囲に調整
    lower_skin = (10, 50, 100)  # 肌色の下限 (H:10, S:50, V:100)
    upper_skin = (20, 150, 255)  # 肌色の上限 (H:20, S:150, V:255)
    
    # 肌色範囲のマスクを作成
    mask = cv2.inRange(hsv, lower_skin, upper_skin)

    # ノイズ除去のためにモルフォロジー変換を適用
    kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (7, 7))
    mask = cv2.morphologyEx(mask, cv2.MORPH_CLOSE, kernel)

    # 枠内部分のみマスクを適用
    mask = mask[box_y1:box_y2, box_x1:box_x2]

    # 輪郭を検出
    contours, _ = cv2.findContours(mask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

    for contour in contours:
        area = cv2.contourArea(contour)
        if 1500 < area < 5000:  # 面積フィルタリング（手の大きさに近いもの）
            return True  # 手が検出された
    return False  # 手が検出されなかった



def generate_frames():
    """
    カメラフレームを生成するジェネレータ
    """
    global product_count, last_detection_time
    while not stop_thread.is_set():  # スレッド停止フラグが立っている場合ループ終了
        with lock:
            if not camera or not camera.isOpened():
                break
            success, frame = camera.read()
            if not success:
                break
            else:
                # 枠を描画
                cv2.rectangle(frame, (box_x1, box_y1), (box_x2, box_y2), (255, 0, 0), 2)


                # 手を検出
                if detect_hand(frame):
                    current_time = time.time()
                    if current_time - last_detection_time > cooldown_time:
                        if product_count > 0:  # 商品数が0以上の場合のみ減少
                            product_count -= 1
                            last_detection_time = current_time
                            print(f"商品数: {product_count}")


                # フレームをJPGにエンコード
                ret, buffer = cv2.imencode('.jpg', frame)
                frame = buffer.tobytes()
                yield (b'--frame\r\n'b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n\r\n')


@app.route('/video_feed')
def video_feed():
    """
    ビデオストリームを返すエンドポイント
    """
    if not is_camera_active:
        return Response(status=403)  # カメラがアクティブでない場合はストリームを返さない
    return Response(generate_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')


@app.route('/camera_screen')
def camera_screen():
    """
    カメラ画面を表示
    """
    initialize_camera()  # カメラを起動
    return render_template('カメラ画面.html')


@app.route('/get_count')
def get_count():
    """
    商品数を取得するエンドポイント
    """
    return jsonify({"product_count": product_count})


@app.route('/')
def home():
    """
    ホーム画面を表示
    """
    release_camera()  # ホームに移動時にカメラを停止
    return render_template('ホーム.html')  # 別のページを表示


if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)





