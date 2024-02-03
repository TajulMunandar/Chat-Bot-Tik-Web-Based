<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        #chat-container {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        #chat-history {
            overflow-y: scroll;
            max-height: 300px;
            border-bottom: 1px solid #ccc;
            padding: 10px;
            margin: 0;
        }

        #user-input-container {
            display: flex;
            padding: 10px;
            align-items: center;
        }

        #user-input {
            flex: 1;
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
        }

        #send-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .bot-message {
            color: #007bff;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div id="chat-container">
        <div id="chat-history"></div>
        <div id="user-input-container">
            <form id="chat-form" action="/chat" method="post">
                @csrf
                <input type="text" name="user_input" id="user-input" placeholder="Tulis pesan...">
                <button type="submit" id="send-button">Kirim</button>
            </form>
        </div>
    </div>

    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        function sendMessage() {
            var userInput = document.getElementById('user-input').value.trim();

            if (userInput === '') {
                console.error('Error: Input cannot be empty');
                return;
            }

            fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    user_input: userInput,
                }),
            })
            .then(response => response.json())
            .then(data => {
                var chatHistory = document.getElementById('chat-history');

                // Tambahkan pesan pengguna dan jawaban chatbot ke riwayat percakapan
                chatHistory.innerHTML += '<div>User: ' + userInput + '</div>';
                if (data && data.response) {
                    chatHistory.innerHTML += '<div class="bot-message">Bot: ' + data.response + '</div>';
                } else {
                    console.error('Error: Invalid server response');
                }

                document.getElementById('user-input').value = '';

                // Auto scroll ke bagian bawah riwayat percakapan
                chatHistory.scrollTop = chatHistory.scrollHeight;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>
