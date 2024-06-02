var chatFlow = {
  'Quel est ton nom ?': {
    response: 'Je suis GitHub Copilot.',
    followUp: {
      'Que fais-tu ?': {
        response: 'Je suis conçu pour aider les développeurs à écrire du code plus rapidement et plus efficacement.',
        followUp: {
          'Peux-tu écrire du code pour moi ?': {
            response: 'Oui, je peux générer du code en fonction de vos instructions.',
            followUp: {
              'Quels langages de programmation connais-tu ?': {
                response: 'Je suis capable de générer du code pour une grande variété de langages de programmation, y compris JavaScript, Python, Java, C++, et bien d\'autres.',
                followUp: null
              }
            }
          }
        }
      }
    }
  },
  'Comment ça va ?': {
    response: 'Je suis un programme, donc je n\'ai pas d\'émotions, mais merci de demander.',
    followUp: null
  }
  // Ajoutez d'autres questions et réponses ici
};

  var chatbotMessages = document.getElementById('chatbot-messages');
  var currentChat = chatFlow; // Variable to keep track of the current state of the chat

  function displayMessage(message, className, boolQuestion) {
    if (boolQuestion) {
      var messageDiv = document.createElement('button');
      messageDiv.textContent = message;
      messageDiv.className = className;
      chatbotMessages.appendChild(messageDiv);
    } else {
    var messageDiv = document.createElement('div');
    messageDiv.textContent = message;
    messageDiv.className = className;
    chatbotMessages.appendChild(messageDiv);
  }
}

  function displayQuestions(questions) {
    chatbotMessages.innerHTML = ''; // Clear the chatbot messages
    for (var question in questions) {
      displayMessage(question, 'chatbot-question',true);
    }
  }
  function hideQuestions() {
  chatbotMessages.innerHTML = '';
}

  displayQuestions(currentChat); // Display the main questions at the beginning

  // Add a click event listener to each question
  chatbotMessages.addEventListener('click', function(e) {
  if (e.target && e.target.className === 'chatbot-question') {
    var question = e.target.textContent;

    // displayMessage('You: ' + question, 'user-message');

    var response = currentChat[question].response;
    var followUp = currentChat[question].followUp;

    // Remove the user's question
    e.target.parentNode.removeChild(e.target);

    hideQuestions(); // Hide the questions after the user has clicked on one

    displayMessage(response, 'chatbot-response',false);

    // If the response has follow-up questions, add them to the conversation
    if (followUp) {
      setTimeout(function() {
        currentChat = followUp; // Update the current state of the chat
        chatbotMessages.innerHTML = ''; // Clear the chatbot messages
        displayQuestions(currentChat);
      }, 2000); // Wait for 2 seconds before displaying the follow-up questions
    } else {
      // Only reset the chat and display the main questions if the user has finished a conversation
      currentChat = chatFlow; // Reset the current state of the chat
      setTimeout(function() {
        chatbotMessages.innerHTML = ''; // Clear the chatbot messages
        displayQuestions(currentChat);
      }, 2000); // Wait for 2 seconds before resetting the chat
    }
  }
});
