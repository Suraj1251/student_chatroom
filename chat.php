<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student ChatRoom</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
   <!-- chat.php (modified body) -->
<div class="chat-wrapper">

    <div class="chat-header-bar">
        <span class="online-indicator"></span> Online: <span id="onlineCount">0</span>
        <h2>Chat Application</h2>
        <p class="user-info">You: <strong id="userDisplay"></strong> | <a href="#" onclick="logout()">Logout</a></p>
    </div>

    <div class="chat-box" id="chat-box"></div>

    <div class="chat-input-area">
    <form id="chatForm" onsubmit="sendMessage(event)" enctype="multipart/form-data">
    <input type="text" id="message" placeholder="Type your message here...">
    <label for="fileInput">📎</label>
<input type="file" id="fileInput" name="file" accept=".jpg,.png,.pdf,.docx,.txt" style="display:none;">

    <button type="submit">➤</button>
</form>

</div>

    
</div>


    <script>
        const username = localStorage.getItem("chatUsername");
if (!username) window.location.href = "index.php";
document.getElementById("userDisplay").innerText = username;

function fetchMessages() {
    fetch(`fetch_messages.php?user=${encodeURIComponent(username)}`)
        .then(res => res.text())
        .then(data => {
            const box = document.getElementById("chat-box");
            box.innerHTML = data;
            box.scrollTo({ top: box.scrollHeight, behavior: 'smooth' });
        });
}


function sendMessage(e) {
    if (e) e.preventDefault();

    const message = document.getElementById('message').value.trim();
    const file = document.getElementById('fileInput').files[0];
    if (!message && !file) return;

    const formData = new FormData();
    formData.append("username", username);
    formData.append("message", message);
    if (file) formData.append("file", file);

    fetch("send_message.php", {
        method: "POST",
        body: formData
    }).then(() => {
        document.getElementById('message').value = '';
        document.getElementById('fileInput').value = '';
        fetchMessages();
    });
}


function handleKey(e) {
    if (e.key === 'Enter') sendMessage();
}

function logout() {
    // Notify server before logging out
    fetch("remove_user.php", {
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `username=${encodeURIComponent(username)}`
    }).then(() => {
        localStorage.removeItem("chatUsername");
        window.location.href = "index.php";
    });
}


// Placeholder for online count simulation
function updateOnlineCount() {
    fetch("get_online_count.php") // You’ll create this
        .then(res => res.text())
        .then(count => document.getElementById("onlineCount").innerText = count);
}


const typingStatus = document.createElement("div");
typingStatus.id = "typingStatus";
typingStatus.style.fontSize = "12px";
typingStatus.style.padding = "6px 16px";
typingStatus.style.color = "#777";
document.querySelector(".chat-box").after(typingStatus);

let typingTimeout;

document.getElementById("message").addEventListener("input", () => {
    clearTimeout(typingTimeout);
    sendTypingStatus("typing");
    typingTimeout = setTimeout(() => sendTypingStatus("idle"), 2000);
});

function sendTypingStatus(status) {
    fetch("typing_status.php", {
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `username=${encodeURIComponent(username)}&status=${status}`
    });
}

function checkTypingStatus() {
    fetch("get_typing_status.php")
        .then(res => res.json())
        .then(data => {
            if (data.status === "typing" && data.user !== username) {
                typingStatus.innerText = `${data.user} is typing...`;
            } else {
                typingStatus.innerText = "";
            }
        });
}


function updateUserActivity() {
    fetch("user_activity.php", {
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `username=${encodeURIComponent(username)}`
    });
}



setInterval(() => {
    fetchMessages();
    updateOnlineCount();
    checkTypingStatus();
    updateUserActivity();
}, 1000);

fetchMessages();
updateOnlineCount();

    </script>
</body>
</html>
