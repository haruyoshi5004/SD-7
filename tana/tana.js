// ローカルストレージから棚の位置を読み込む関数
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

// ローカルストレージに棚の位置を保存する関数
function saveShelfPositions() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "save_shelves.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("棚の位置が保存されました！");
        } else if (xhr.readyState == 4) {
            alert("棚の位置の保存に失敗しました。");
        }
    };
    xhr.send(JSON.stringify(shelves));
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
