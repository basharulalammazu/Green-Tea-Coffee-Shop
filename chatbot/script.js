const chatbotBtn = document.getElementById('chatbot-btn');
    const chatbot = document.getElementById('chatbot');
    const sendBtn = document.getElementById('send-btn');
    const userInput = document.getElementById('user-input');
    const messages = document.getElementById('chatbot-messages');

    async function fetchMenu(data) {
        try {
            const response = await fetch(`chatbot/fetch_menu.php?category=${data}`);
            if (!response.ok) throw new Error('Failed to fetch menu.');
            const menuData = await response.json();
            let menuMessage = "Here is our menu:\n";
            menuData.forEach((item, index) => {
                menuMessage += `${index + 1}. ${item.name} - $${item.price}\n`;
            });
            return menuMessage + 'Would you like to order anything?';
        } catch (error) {
            console.error(error);
            return 'Sorry, there was an error fetching the menu.';
        }
    }
    

    const botReplies = {
        'hi': 'Hello! How can I help you today?',
        'hello': 'Hi there! How can I assist you?',
        'hey': 'Hey! How can I assist you today?',
        'help': 'Sure! What kind of help do you want?',
        'good morning': 'Good morning! Welcome to our Green Tea Coffee Shop! How can I assist you today?',
        'good afternoon': 'Good afternoon! How can I help you?',
        'good evening': 'Good evening! How can I assist you?',
        'bye': 'Goodbye! Have a great day!',
        'ai': 'Yes! I am your AI assitant to help you through your needs.',
        'goodbye': 'Goodbye! Take care!',   
        'shop name': 'Our shop name is Green Tea Coffee Shop.',                        
        'coffee': async() => {
            const menuMessage = await fetchMenu("Coffee");
            return menuMessage;
        },
        'tea': async() => {
            const menuMessage = await fetchMenu("Tea");
            return menuMessage;
            },
        'matcha': async() => {
            const menuMessage = await fetchMenu("Matcha");
            return menuMessage;
        },
        'drinks': async() => {
            const menuMessage = await fetchMenu("Drinks");
            return menuMessage;
        },
        'other': async() => {
            const menuMessage = await fetchMenu("Others");
            return menuMessage;
        },
        'matcha latte': 'Our Matcha Latte is $5.99 for 250ml. It’s made with premium matcha and steamed milk for a smooth taste.',
        'green tea cappuccino': 'The Green Tea Cappuccino is $4.49 for 200ml. It blends green tea with a creamy cappuccino base.',
        'hours': 'Our shop is open from 8 AM to 8 PM every day.',
        'open': 'Our shop is open from 8 AM to 8 PM every day.',
        'close': 'Our shop is always open from 8 AM to 8 PM every day.',
        'location': 'We are located at 123 Green Street, Dhaka.',
        'address': 'We are located at 123 Green Street, Dhaka.',
        'order': 'You can place your order online through our website or at our shop. Need help with anything specific?',
        'website': 'You can visit our website at www.greenteacoffee.com for more information and to place an order.',
        'shop': 'Our shop is located at 123 Green Street, Dhaka. Feel free to visit us anytime from 8 AM to 8 PM!',
        'online': 'You can place your order online on our website at www.greenteacoffee.com.',
        'order online': 'To order online, simply visit our website at www.greenteacoffee.com, and you can select your favorite items.',
        'webshop': 'Our webshop is available at www.greenteacoffee.com, where you can browse the menu and place your order.',
        'e-commerce': 'We offer an e-commerce platform on our website, allowing you to order your favorite drinks online anytime.',
        'offer': 'We offer a variety of drinks, including coffee, tea, and matcha-based beverages. Would you like to see our menu?',
        'menu': async () => {
            const menuMessage = await fetchMenu("all");
            return menuMessage;
        },
        'delivery': 'We offer delivery services! You can place an order through our website, and we’ll bring your drinks to your doorstep.',
        'delivery options': 'We offer home delivery through our website. Just place your order online and select delivery during checkout.',
        'takeaway': 'You can also place a takeaway order in person or through our website and pick it up at the shop.',
        'order now': 'To place an order, you can visit our website or place an order at our shop. Would you like to browse our menu?',
        'place order': 'You can place your order on our website, or you can visit our shop in person to place an order.',
        'checkout': 'Once you’ve selected your items, you can proceed to checkout on our website to complete your purchase.',
        'payment': 'You can pay for your order online via credit/debit card on our website, or pay in person at the shop.',
        'default': 'I am sorry, I didn’t quite understand that. Could you please rephrase?'
    };

    // Function to normalize and match variations of input using similarity (Gemini Concept)
    const analyzeAndReply = (userText) => {
        userText = userText.toLowerCase();

        // Simulated similarity function (in reality, this would be done with an AI model like Gemini)
        const findBestMatch = (inputText) => {
            const similarities = Object.keys(botReplies).map(key => {
                let similarityScore = 0;
                if (inputText.includes(key)) {
                    similarityScore = 1;  // Simplified match check
                }
                return { key, score: similarityScore };
            });

            const bestMatch = similarities.reduce((max, curr) => (curr.score > max.score ? curr : max), { score: 0 });
            return botReplies[bestMatch.key] || botReplies['default'];
        };

        // Get response based on matching text
        return findBestMatch(userText);
    };

    
    function toggleChatbot() {
        chatbot.style.display = chatbot.style.display === 'flex' ? 'none' : 'flex';
    }

    const addMessage = (text, sender) => {
        const message = document.createElement('div');
        message.classList.add('message', sender);
        message.textContent = text;
        messages.appendChild(message);
        messages.scrollTop = messages.scrollHeight;
    };

    async function handleUserInput(userText) {
        const reply = analyzeAndReply(userText);
        
        addMessage(userText, 'user');
        
        if (typeof reply === 'function') {
            const menuMessage = await reply();
            addMessage(menuMessage, 'bot');
        } else 
            addMessage(reply, 'bot');
        
    }

    chatbotBtn.addEventListener('click', toggleChatbot);
    sendBtn.addEventListener('click', () => {
        const userText = userInput.value.trim();
        if (userText) {
            handleUserInput(userText);
            userInput.value = '';
        }
    });
    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendBtn.click();
        }
    });
