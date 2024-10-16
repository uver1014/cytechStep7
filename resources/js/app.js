import './bootstrap';

window.checkSubmit = function () {
    if (window.confirm('登録してよろしいですか？')) {
        return true;
    } else {
        return false;
    }
};

window.checkUpdate = function () {
    if (window.confirm('更新してよろしいですか？')) {
        return true;
    } else {
        return false;
    }
};


window.checkDelete = function () {
    if (window.confirm('削除してよろしいですか？')) {
        return true;
    } else {
        return false;
    }
};