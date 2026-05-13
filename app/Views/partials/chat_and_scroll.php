<?php
/**
 * =========================================================================
 * TÊN FILE: app/Views/partials/chat_and_scroll.php
 * * MÔ TẢ: 
 * File này đóng vai trò là một Component (Thành phần giao diện độc lập). 
 * Nó chứa mã HTML, CSS và JavaScript cho 2 tính năng:
 * 1. Nút "Lên đầu trang" (Scroll-to-top)
 * 2. Khung Chatbot Hỗ trợ trực tiếp (Live Chat)
 *
 * CÁCH SỬ DỤNG TRONG MÔ HÌNH MVC:
 * - Thay vì lặp lại code, ở bất kỳ file giao diện nào (home.php, register.php...),
 * bạn chỉ cần gọi file này ra bằng lệnh include của PHP đặt ngay trên thẻ đóng </body>.
 * - Ví dụ: <?php include __DIR__ . '/partials/chat_and_scroll.php'; ?>
 * * CÁCH HOẠT ĐỘNG:
 * - UI (CSS): Áp dụng chuẩn Frosted Glass (Kính mờ). Nền trong suốt tự động lấy 
 * màu từ các biến của Theme (--card-bg, --text-color) nên sẽ đồng bộ hoàn hảo 
 * giữa chế độ Sáng/Tối.
 * - Logic (JS): Bắt sự kiện 'scroll' (cuộn trang) để ẩn/hiện nút mũi tên. Bắt 
 * sự kiện 'click' để trượt mượt mà lên top hoặc mở/đóng popup Chatbot.
 * =========================================================================
 */
?>

<style>
    /* Nút bấm trôi nổi (Góc dưới bên phải) */
    .floating-widget-container {
        position: fixed;
        bottom: 30px;
        right: 30px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        z-index: 1050; /* Đảm bảo luôn nổi trên cùng */
    }

    /* Thiết kế nút bấm chuẩn Glassmorphism */
    .float-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        backdrop-filter: blur(15px);
        color: var(--text-color);
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); /* Hiệu ứng kẹo dẻo nhẹ */
    }

    [data-theme="dark"] .float-btn { box-shadow: 0 10px 20px rgba(0,0,0,0.4); }

    .float-btn:hover {
        transform: translateY(-5px) scale(1.1);
        background: linear-gradient(45deg, #00c6ff, #0072ff);
        color: #ffffff;
        border-color: transparent;
    }

    /* Ẩn nút Scroll To Top mặc định */
    #scrollToTopBtn {
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
    }
    #scrollToTopBtn.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Cửa sổ Chatbot */
    .chat-window {
        position: fixed;
        bottom: 90px; /* Nằm ngay trên nút bấm */
        right: 30px;
        width: 350px;
        height: 450px;
        border-radius: 1.2rem;
        background: var(--card-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid var(--border-color);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        z-index: 1049;
        
        /* Hiệu ứng trượt lên mượt mà */
        opacity: 0;
        visibility: hidden;
        transform: translateY(50px) scale(0.9);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        transform-origin: bottom right;
    }

    [data-theme="dark"] .chat-window { box-shadow: 0 15px 35px rgba(0,0,0,0.5); }

    .chat-window.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }

    /* Header của Khung Chat */
    .chat-header {
        background: linear-gradient(45deg, #00c6ff, #0072ff);
        padding: 15px 20px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: bold;
    }

    /* Khung nội dung tin nhắn */
    .chat-body {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        color: var(--text-color);
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* Bong bóng tin nhắn */
    .chat-bubble {
        max-width: 80%;
        padding: 10px 15px;
        border-radius: 1rem;
        font-size: 0.9rem;
        line-height: 1.4;
    }
    .chat-bot {
        background: rgba(128, 128, 128, 0.1);
        align-self: flex-start;
        border-bottom-left-radius: 0.2rem;
    }
    .chat-user {
        background: #0072ff;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 0.2rem;
    }

    /* Khung nhập liệu */
    .chat-footer {
        padding: 15px;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 10px;
    }
    .chat-input {
        flex: 1;
        background: rgba(128, 128, 128, 0.05);
        border: 1px solid var(--border-color);
        color: var(--text-color);
        border-radius: 2rem;
        padding: 8px 15px;
        outline: none;
        transition: 0.3s;
    }
    .chat-input:focus { border-color: #0072ff; }
    .chat-send-btn {
        background: #0072ff;
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
    }
    .chat-send-btn:hover { transform: scale(1.1); background: #00c6ff; }
</style>

<div id="liveChatWindow" class="chat-window">
    <div class="chat-header">
        <div><i class="fas fa-headset me-2"></i> Chuyên gia TTB Music</div>
        <button id="closeChatBtn" style="background:none; border:none; color:white; font-size:1.2rem; cursor:pointer;"><i class="fas fa-times"></i></button>
    </div>
    <div class="chat-body" id="chatBody">
        <div class="chat-bubble chat-bot">
            Xin chào! 👋 Mình là chuyên gia tư vấn nhạc cụ của TTB Music. Mình có thể giúp bạn tìm một cây đàn ưng ý hay tư vấn thủ tục trả góp không?
        </div>
    </div>
    <div class="chat-footer">
        <input type="text" id="chatInput" class="chat-input" placeholder="Nhập tin nhắn...">
        <button class="chat-send-btn" id="sendChatBtn"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<div class="floating-widget-container">
    <button id="openChatBtn" class="float-btn" title="Hỗ trợ trực tuyến">
        <i class="fas fa-comment-dots"></i>
    </button>
    
    <button id="scrollToTopBtn" class="float-btn" title="Lên đầu trang">
        <i class="fas fa-arrow-up"></i>
    </button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- LOGIC SCROLL TO TOP ---
        const scrollBtn = document.getElementById("scrollToTopBtn");
        
        // Hiện nút khi cuộn xuống 300px
        window.addEventListener("scroll", function() {
            if (window.scrollY > 300) {
                scrollBtn.classList.add("show");
            } else {
                scrollBtn.classList.remove("show");
            }
        });

        // Trượt mượt mà lên đầu trang khi click
        scrollBtn.addEventListener("click", function() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });

        // --- LOGIC CHATBOT ---
        const chatWindow = document.getElementById("liveChatWindow");
        const openChatBtn = document.getElementById("openChatBtn");
        const closeChatBtn = document.getElementById("closeChatBtn");
        const chatInput = document.getElementById("chatInput");
        const sendChatBtn = document.getElementById("sendChatBtn");
        const chatBody = document.getElementById("chatBody");

        // Mở/Đóng cửa sổ Chat
        openChatBtn.addEventListener("click", () => {
            chatWindow.classList.toggle("show");
            chatInput.focus();
        });
        closeChatBtn.addEventListener("click", () => chatWindow.classList.remove("show"));

        // Tính năng gửi tin nhắn ảo (tạo UI tin nhắn)
        function sendMessage() {
            const text = chatInput.value.trim();
            if (text !== "") {
                // Tạo bong bóng tin nhắn của User
                const userMsg = document.createElement("div");
                userMsg.className = "chat-bubble chat-user";
                userMsg.innerText = text;
                chatBody.appendChild(userMsg);
                
                // Xóa ô nhập và cuộn xuống cuối
                chatInput.value = "";
                chatBody.scrollTop = chatBody.scrollHeight;

                // Giả lập bot trả lời sau 1 giây
                setTimeout(() => {
                    const botMsg = document.createElement("div");
                    botMsg.className = "chat-bubble chat-bot";
                    botMsg.innerHTML = "Cảm ơn bạn! Hiện tại chuyên viên đang bận, tin nhắn của bạn đã được ghi nhận. Vui lòng để lại số điện thoại nhé!";
                    chatBody.appendChild(botMsg);
                    chatBody.scrollTop = chatBody.scrollHeight;
                }, 1000);
            }
        }

        // Bắt sự kiện click nút gửi hoặc nhấn Enter
        sendChatBtn.addEventListener("click", sendMessage);
        chatInput.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                sendMessage();
            }
        });
    });
</script>