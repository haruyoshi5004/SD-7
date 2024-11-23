// canvas要素と2D描画コンテキスト
const canvas = document.createElement('canvas');
canvas.id = 'mapCanvas';
canvas.width = 800;
canvas.height = 600;
document.getElementById('canvasContainer').appendChild(canvas);

const ctx = canvas.getContext('2d');

// 棚オブジェクトのリスト（デフォルトの位置）
let initialShelves = [
    { id: 1, x: 100, y: 100, width: 100, height: 50, selected: false },
    { id: 2, x: 200, y: 100, width: 100, height: 50, selected: false },
    // その他の棚...
];

// 現在の棚の位置（デフォルト位置から変更する可能性がある）
let shelves = [...initialShelves];

// 棚の位置を読み込む関数
function loadShelfPositions() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "load_shelves.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            shelves = JSON.parse(xhr.responseText);
            drawShelves();
        } else if (xhr.readyState == 4) {
            alert("棚の位置の読み込みに失敗しました。");
        }
    };
    xhr.send();
}

// 棚の位置を保存する関数
function saveShelfPositions() {
    const formData = new FormData();
    shelves.forEach((shelf, index) => {
        formData.append(`shelves[${index}][id]`, shelf.id);
        formData.append(`shelves[${index}][x]`, shelf.x);
        formData.append(`shelves[${index}][y]`, shelf.y);
        formData.append(`shelves[${index}][width]`, shelf.width);
        formData.append(`shelves[${index}][height]`, shelf.height);
        formData.append(`shelves[${index}][selected]`, shelf.selected);
    });

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "save_shelves.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("棚の位置が保存されました！");
        }
    };
    xhr.send(formData);
}

// 棚位置をリセットする関数
function resetShelfPositions() {
    shelves = [...initialShelves]; // 初期位置に戻す
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "reset_shelves.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            drawShelves(); // 再描画
            alert("棚の位置がリセットされました！");
        } else if (xhr.readyState == 4) {
            alert("棚の位置のリセットに失敗しました。");
        }
    };
    xhr.send();
}

// ページが読み込まれたときに位置を復元
window.onload = function() {
    loadShelfPositions();
    drawShelves();
};

// ドラッグ状態を追跡
let draggedShelf = null;
let offsetX, offsetY;

function drawShelves() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    shelves.forEach(shelf => {
        // 選択された棚は赤く、他の棚は緑に表示
        ctx.fillStyle = shelf.selected ? "red" : "#5f9";
        ctx.fillRect(shelf.x, shelf.y, shelf.width, shelf.height);
        ctx.strokeRect(shelf.x, shelf.y, shelf.width, shelf.height);
    });
}

// 棚をクリックしたときの処理
canvas.addEventListener('mousedown', (e) => {
    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    // クリックした棚を見つけて選択状態に変更
    let clickedShelf = shelves.find(shelf =>
        x >= shelf.x && x <= shelf.x + shelf.width &&
        y >= shelf.y && y <= shelf.y + shelf.height
    );

    if (clickedShelf) {
        // シフトキーが押されている場合は選択を切り替える
        if (e.shiftKey) {
            clickedShelf.selected = !clickedShelf.selected;
        } else {
            // 選択に関係なくドラッグできるように設定
            draggedShelf = clickedShelf;
            offsetX = x - draggedShelf.x;
            offsetY = y - draggedShelf.y;
        }

        drawShelves();  // 再描画
    }
});

// 棚のドラッグ移動用のコード
canvas.addEventListener('mousemove', (e) => {
    if (draggedShelf) {
        const rect = canvas.getBoundingClientRect();
        draggedShelf.x = e.clientX - rect.left - offsetX;
        draggedShelf.y = e.clientY - rect.top - offsetY;
        drawShelves();
    }
});

canvas.addEventListener('mouseup', () => {
    draggedShelf = null;
});

// 位置保存ボタンのクリックイベント
document.getElementById('saveButton').addEventListener('click', saveShelfPositions);

// リセットボタンのクリックイベント
document.getElementById('resetButton').addEventListener('click', resetShelfPositions);

// 新しいCanvas作成ボタンのクリックイベント
document.getElementById('createCanvasButton').addEventListener('click', createNewCanvas);

function createNewCanvas() {
    // 新しいcanvas要素を作成
    const newCanvas = document.createElement('canvas');
    newCanvas.width = 800;
    newCanvas.height = 600;
    newCanvas.style.border = '1px solid black';

    // 描画コンテキストを取得
    const newCtx = newCanvas.getContext('2d');

    // ここにcanvasの描画内容を追加（例：四角形を描く）
    newCtx.fillStyle = 'lightblue';
    newCtx.fillRect(10, 10, 100, 100);

    // canvasをコンテナに追加
    document.getElementById('canvasContainer').appendChild(newCanvas);
}
