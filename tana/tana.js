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
// ページが読み込まれたときに位置を復元
window.onload = function() {
    loadShelfPositions();
    drawShelves();
};

// 位置保存ボタンのクリックイベント
document.getElementById('saveButton').addEventListener('click', saveShelfPositions);

// リセットボタンのクリックイベント
document.getElementById('resetButton').addEventListener('click', resetShelfPositions);
