$(document).ready(function () {
    $('#openChatbox').click(function () {
        $('#chatbox').toggle();
        $(this).toggleClass('rotate')
    });
    $('#closeChatbox').click(function () {
        $('#chatbox').hide();
        $('#openChatbox').removeClass('rotate')
    })
    $('#sendMessage').click(function () {
        let userMessage = $('#userMessage').val();
        if (userMessage.trim() !== '') {
            appendMessage('user', userMessage);
            sendMessageToAPI(userMessage);
            $('#userMessage').val("")
        }
    })

    function appendMessage(sender, message) {
        var messageClass = sender === 'user' ? 'user' : 'bot';
        var messageElement = $('<div class="message ' + messageClass + '"></div>').text(message);
        $('#chatboxBody').append(messageElement);
        $('#chatboxBody').scrollTop($('#chatboxBody')[0].scrollHeight);
    }

    function sendMessageToAPI(message) {
        $.ajax({
            url: 'https://api.example.com/chatbot',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({message: message}),
            success: function (response) {
                appendMessage('bot', response.reply);
            },
            error: function () {
                appendMessage('bot', 'Sorry, Something went wrong')
            }
        })
    }
})

