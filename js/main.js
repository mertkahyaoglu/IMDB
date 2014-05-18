document.getElementById('search').onsubmit = function() {
    if (!this.FileName.value) {
        alert ("Please Enter a File Name");
        return false;
    }
};