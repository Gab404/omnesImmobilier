document.getElementById('chatbot-input').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      var input = this.value;
      this.value = '';

      var messageDiv = document.createElement('div');
      messageDiv.textContent = 'You: ' + input;
      document.getElementById('chatbot-messages').appendChild(messageDiv);

      // TODO: Send input to chatbot and get response

      var response = 'Chatbot: ' + 'Sorry, I am not programmed to respond yet.';
      var responseDiv = document.createElement('div');
      responseDiv.textContent = response;
      document.getElementById('chatbot-messages').appendChild(responseDiv);
    }
  });