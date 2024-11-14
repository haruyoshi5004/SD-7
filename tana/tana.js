// canvas要素と2D描画コンテキスト
const canvas = document.getElementById('mapCanvas');
const ctx = canvas.getContext('2d');

// 棚オブジェクトのリスト（デフォルトの位置）
let initialShelves = [
    { id: 1, x: 100, y: 100, width: 100, height: 50, selected: false },
    { id: 2, x: 200, y: 100, width: 100, height: 50, selected: false },
    { id: 3, x: 300, y: 100, width: 100, height: 50, selected: false },
    { id: 4, x: 400, y: 100, width: 100, height: 50, selected: false },
    { id: 5, x: 500, y: 100, width: 100, height: 50, selected: false },
    { id: 6, x: 600, y: 100, width: 100, height: 50, selected: false },
    // 左側棚
    { id: 10, x: 50, y: 150, width: 50, height: 100, selected: false },
    { id: 11, x: 50, y: 250, width: 50, height: 100, selected: false },
    { id: 12, x: 50, y: 350, width: 50, height: 100, selected: false },
    // 左1側棚
    { id: 15, x: 175, y: 250, width: 50, height: 100, selected: false },
    { id: 16, x: 175, y: 350, width: 50, height: 100, selected: false },
    // 左2
    { id: 20, x: 275, y: 250, width: 50, height: 100, selected: false },
    { id: 21, x: 275, y: 350, width: 50, height: 100, selected: false },
    // 中央
    { id: 25, x: 375, y: 250, width: 50, height: 100, selected: false },
    { id: 26, x: 375, y: 350, width: 50, height: 100, selected: false },
    // 右2
    { id: 30, x: 475, y: 250, width: 50, height: 100, selected: false },
    { id: 31, x: 475, y: 350, width: 50, height: 100, selected: false },
    // 右1
    { id: 35, x: 575, y: 250, width: 50, height: 100, selected: false },
    { id: 36, x: 575, y: 350, width: 50, height: 100, selected: false },
    // 右側棚
    { id: 40, x: 700, y: 150, width: 50, height: 100, selected: false },
    { id: 41, x: 700, y: 250, width: 50, height: 100, selected: false },
    { id: 42, x: 700, y: 350, width: 50, height: 100, selected: false },
];
// 現在の棚の位置（デフォルト位置から変更する可能性がある）
let shelves = [...initialShelves];

// ローカルストレージから棚の位置を読み込む関数
function loadShelfPositions() {
    const savedPositions = localStorage.getItem('shelfPositions');
    if (savedPositions) {
        shelves = JSON.parse(savedPositions);
    }
}

// ローカルストレージに棚の位置を保存する関数
function saveShelfPositions() {
    localStorage.setItem('shelfPositions', JSON.stringify(shelves));
    alert("棚の位置が保存されました！");
}

// 棚位置をリセットする関数
function resetShelfPositions() {
    shelves = [...initialShelves]; // 初期位置に戻す
    localStorage.removeItem('shelfPositions'); // ローカルストレージをリセット
    drawShelves(); // 再描画
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
