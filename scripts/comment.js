function submitForm(event) {
    //prevent page refresh
    event.preventDefault();
    var comment_value = document.getElementById("comment_id").value;
    var notify_bool = document.getElementById("checkbox_id");
    //checked if notify checkbox is checked 
    if (notify_bool.checked) {
        notify_value = 1;        
    } else {
        notify_value = 0;
    }

    if (!/\S/.test(comment_value)) {
        document.getElementById("comment_error").innerHTML = "This comment is invalid";
    } else {
        //stringify objects
        var JSON_obj = { comment: comment_value, notify: notify_value, pageid: page_id, parentid: parent_id };
        var JSON_string = JSON.stringify(JSON_obj);
        //send request to sever
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "../usercomment/addcomment.php", true);
        xhttp.setRequestHeader("Content-Type", "application/JSON");
        xhttp.send(JSON_string);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //show notify box
                document.getElementById("notifyToggle").style.display = "block";
                var sendResponse = xhttp.responseText;
                //add response if user has not logged in
                document.getElementById("comment_error").innerHTML = sendResponse;
                //clear input field
                document.getElementById("comment_id").value = '';
            }
            loadComment();    
        }
    }
}
function loadComment() {
    var xhttp2 = new XMLHttpRequest();
    xhttp2.open("GET", "../usercomment/loadcomment.php?pageid="+page_id+"&parentid="+parent_id+"&show_more="+show_more+"&offset="+offset+"&t="+Math.random(), true);
    xhttp2.send();
    xhttp2.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var loadResponse = xhttp2.responseText;
            //add response to an array that will display all comments on page load
            document.getElementById("comment_box").innerHTML = loadResponse;
            document.getElementById('comment_btn').className = "btn btn-warning fw-bold my-3 p-2";
            document.getElementById('comment_btn').innerHTML = "Comment";
            document.getElementById("replyIcon").style.display = "none";
            document.getElementById("notifyToggle").style.display = "block";
            parent_id = 0;
        }
    }
}

function unComment(id) {
    if (confirm('You are about to delete that comment permanently!')) {
        var deleteId = id.value;
        var xhttp4 = new XMLHttpRequest();
        xhttp4.open("GET", "../usercomment/deletecomment.php?deleteId="+deleteId+"&t="+Math.random(), true);
        xhttp4.send();
        xhttp4.onreadystatechange = function() {
            if (this.readyState == 4) {
                loadComment();
            }
        }
    } else {
        loadComment();
    }
        loadComment();
}

function replyComment(reply) {
    document.getElementById('comment_btn').innerHTML = "Reply";
    document.getElementById("replyIcon").style.display = "block";
    document.getElementById("notifyToggle").style.display = "none";
    document.getElementById('comment_btn').className = "btn btn-dark fw-bold text-light my-3 p-2";
    var id = reply.getAttribute('id');
    document.getElementById('hidden_id').value = id;
    parent_id = id;
}


function upvoteComment(foo) {
    var voteId = foo.value;
    var voteType = "UPVOTE";
    var xhttp3 = new XMLHttpRequest();
    xhttp3.open("GET", "../usercomment/reaction.php?voteId="+voteId+"&voteType="+voteType+"&t="+Math.random(), true);
    xhttp3.send();
    xhttp3.onreadystatechange = function() {
        if (this.readyState == 4 ) {
            //add response if user has not logged in
            document.getElementById("comment_error").innerHTML = this.responseText; 
        }
    }
    loadComment();
}
function downvoteComment(foo) {
    var voteId = foo.value;
    var voteType = "DOWNVOTE";
    var xhttp3 = new XMLHttpRequest();
    xhttp3.open("GET", "../usercomment/reaction.php?voteId="+voteId+"&voteType="+voteType+"&t="+Math.random(), true);
    xhttp3.send();
    xhttp3.onreadystatechange = function() {
        if (this.readyState == 4 ) {
            //add response if user has not logged in
            document.getElementById("comment_error").innerHTML = this.responseText;            
        }
    }
    loadComment();
}

function showMore(){
    show_more = 1;
    loadComment();
}

function showLess() {
    show_more = 0;
    loadComment();
}

