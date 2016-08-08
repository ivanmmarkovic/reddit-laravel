var voteSpans = document.querySelectorAll(".vote");
for (var i = 0; i < voteSpans.length; i++) {
    voteSpans[i].addEventListener('click', vote, false);
}

function vote() {
    var voteType = this.dataset.votetype;
    var parentDiv = this.parentNode;
    var postId = parentDiv.dataset.postid;
    var userId = parentDiv.dataset.userid;
    var spanClicked = this;


    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var obj = JSON.parse(xhr.responseText);
            console.log(obj);
            if ("warning" in obj) {
                var pWarning = document.createElement("p");
                pWarning.textContent = obj.warning;
                spanClicked.parentNode.appendChild(pWarning);
                setTimeout(function functionName() {
                    spanClicked.parentNode.removeChild(pWarning);
                }, 3000);
            }
            else {
                if (spanClicked.dataset.votetype == "up") {
                    spanClicked.textContent = obj.up;
                    spanClicked.nextElementSibling.textContent = obj.result;
                    spanClicked.nextElementSibling.nextElementSibling.textContent = obj.down;
                }
                else {
                    spanClicked.textContent = obj.down;
                    spanClicked.previousElementSibling.textContent = obj.result;
                    spanClicked.previousElementSibling.previousElementSibling.textContent = obj.up;
                }
            }
        }
    }

    xhr.open('POST', url, true);
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
    xhr.send("postId=" + postId + "&userId=" + userId + "&voteType=" + voteType + "&_token=" + token);
}
