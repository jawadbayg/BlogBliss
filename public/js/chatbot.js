
document.addEventListener('DOMContentLoaded', function() {
    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatbotInterface = document.getElementById('chatbot-interface');
    const chatbotClose = document.getElementById('chatbot-close');

    // Ensure the chatbot is hidden initially
    chatbotInterface.style.display = 'none';

    // Toggle chatbot interface visibility
    chatbotToggle.addEventListener('click', function(event) {
        event.preventDefault();
        if (chatbotInterface.style.display === 'none' || chatbotInterface.style.display === '') {
            chatbotInterface.style.display = 'flex';
        } else {
            chatbotInterface.style.display = 'none';
        }
    });

    // Close chatbot interface
    chatbotClose.addEventListener('click', function() {
        chatbotInterface.style.display = 'none';
    });

    // Handle sending messages (dummy example)
    document.getElementById('send-message').addEventListener('click', function() {
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');

        if (chatInput.value.trim()) {
            const message = document.createElement('div');
            message.textContent = chatInput.value;
            chatMessages.appendChild(message);
            chatInput.value = '';
            chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll to bottom
        }
    });
});

