<?php
/**
 * =========================================================================
 * TÊN FILE: app/Views/partials/chat_and_scroll.php
 * * MÔ TẢ CHI TIẾT VÀ CÁCH SỬ DỤNG:
 * File này đóng vai trò là một Component (Thành phần giao diện độc lập).
 * Nó chứa mã HTML, CSS và JavaScript cho 2 tính năng:
 * 1. Nút "Lên đầu trang" (Scroll-to-top)
 * 2. Khung Chatbot Hỗ trợ trực tiếp (Live Chat)
 * * CÁCH NHÚNG VÀO CÁC TRANG KHÁC (THEO CHUẨN MVC):
 * - Thay vì lặp lại code, ở bất kỳ file giao diện nào (home.php, register.php...),
 * bạn chỉ cần gọi file này ra bằng lệnh include của PHP đặt ngay trên thẻ đóng </body>.
 * - Cú pháp: <?php include __DIR__ . '/partials/chat_and_scroll.php'; ?>
 * * CÁCH HOẠT ĐỘNG CỦA LƯỚI GIAO DIỆN (UI/UX):
 * - Khung Chatbot được thiết lập tọa độ (right: 100px) để luôn mở ra bên trái 
 * của trục nút bấm, tránh tình trạng đè giao diện.
 * - Thứ tự HTML được sắp xếp: Nút Scroll ở trên, nút Chat ở dưới. Giúp nút Chat 
 * luôn neo cố định ở góc màn hình dù nút Scroll có ẩn đi hay hiện ra.
 * =========================================================================
 */
?>

<style>
    /* Trục chứa 2 nút bấm trôi nổi (Góc dưới bên phải) */
    .floating-widget-container {
        position: fixed;
        bottom: 30px;
        right: 30px;
        display: flex;
        flex-direction: column; /* Xếp dọc các nút */
        gap: 15px; /* Khoảng cách giữa 2 nút */
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
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    [data-theme="dark"] .float-btn { box-shadow: 0 10px 20px rgba(0,0,0,0.4); }

    .float-btn:hover {
        transform: translateY(-5px) scale(1.1);
        background: linear-gradient(45deg, #00c6ff, #0072ff);
        color: #ffffff;
        border-color: transparent;
    }

    /* Trạng thái ẩn/hiện của nút Scroll To Top */
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

    /* ================= CỬA SỔ CHATBOT ================= */
    .chat-window {
        position: fixed;
        bottom: 30px; /* Đặt cùng độ cao với trục nút bấm */
        right: 100px; /* Đẩy sang trái 100px để không đè lên nút bấm */
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
        
        /* Hiệu ứng trượt lên mượt mà từ góc phải dưới */
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

    /* Khung chứa nội dung cuộc hội thoại */
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

    /* Khu vực nhập liệu tin nhắn */
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
    <button id="scrollToTopBtn" class="float-btn" title="Lên đầu trang">
        <i class="fas fa-arrow-up"></i>
    </button>

    <button id="openChatBtn" class="float-btn" title="Hỗ trợ trực tuyến">
        <i class="fas fa-comment-dots"></i>
    </button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // --- LOGIC: LÊN ĐẦU TRANG ---
        const scrollBtn = document.getElementById("scrollToTopBtn");
        
        // Hàm kiểm tra container cuộn hiện tại (nếu đang ở trang chi tiết sản phẩm thì cuộn chi tiết, ngược lại cuộn window)
        function getScrollContainer() {
            const detailContainer = document.getElementById('page-detail');
            const isDetailActive = detailContainer && (detailContainer.classList.contains('active-sheet') || detailContainer.classList.contains('active'));
            if (isDetailActive) {
                return detailContainer;
            }
            return window;
        }

        // Lắng nghe sự kiện scroll (dùng capture: true để bắt được sự kiện scroll của container con #page-detail)
        const handleScroll = () => {
            const container = getScrollContainer();
            const scrollTop = container === window ? window.scrollY : container.scrollTop;
            if (scrollTop > 300) {
                scrollBtn.classList.add("show");
            } else {
                scrollBtn.classList.remove("show");
            }
        };

        window.addEventListener("scroll", handleScroll, { passive: true });
        window.addEventListener("scroll", handleScroll, { capture: true, passive: true });

        // Click để cuộn mượt mà lên đầu container tương ứng
        scrollBtn.addEventListener("click", function() {
            const container = getScrollContainer();
            if (container === window) {
                window.scrollTo({ top: 0, behavior: "smooth" });
            } else {
                container.scrollTo({ top: 0, behavior: "smooth" });
            }
        });


        // --- LOGIC: CHATBOT TRỰC TUYẾN ---
        const chatWindow = document.getElementById("liveChatWindow");
        const openChatBtn = document.getElementById("openChatBtn");
        const closeChatBtn = document.getElementById("closeChatBtn");
        const chatInput = document.getElementById("chatInput");
        const sendChatBtn = document.getElementById("sendChatBtn");
        const chatBody = document.getElementById("chatBody");

        // Bật/tắt class 'show' để CSS chạy hiệu ứng trượt lên/xuống
        openChatBtn.addEventListener("click", () => {
            chatWindow.classList.toggle("show");
            if (chatWindow.classList.contains("show")) chatInput.focus();
        });
        closeChatBtn.addEventListener("click", () => chatWindow.classList.remove("show"));

        // Hàm xử lý tạo bong bóng tin nhắn
        function sendMessage() {
            const text = chatInput.value.trim();
            if (text !== "") {
                // 1. Tạo tin nhắn của người dùng
                const userMsg = document.createElement("div");
                userMsg.className = "chat-bubble chat-user";
                userMsg.innerText = text;
                chatBody.appendChild(userMsg);
                
                chatInput.value = "";
                chatBody.scrollTop = chatBody.scrollHeight; // Tự động cuộn xuống cuối

                // 2. Giả lập Bot phản hồi sau 1 giây
                setTimeout(() => {
                    const botMsg = document.createElement("div");
                    botMsg.className = "chat-bubble chat-bot";
                    botMsg.innerHTML = "Cảm ơn bạn! Hiện tại chuyên viên đang bận, tin nhắn của bạn đã được ghi nhận. Vui lòng để lại số điện thoại nhé!";
                    chatBody.appendChild(botMsg);
                    chatBody.scrollTop = chatBody.scrollHeight;
                }, 1000);
            }
        }

        // Kích hoạt gửi tin nhắn khi bấm nút hoặc ấn Enter
        sendChatBtn.addEventListener("click", sendMessage);
        chatInput.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                sendMessage();
            }
        });
    });
</script>