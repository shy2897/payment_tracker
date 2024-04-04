


        // TOGGLE
        const toggleBtn = document.querySelector('.toggle_btn')
        const toggleBtnIcon = document.querySelector('.toggle_btn i')
        const dropDownMenu = document.querySelector('.dropdown_menu')

        toggleBtn.onclick = function () {
        const isOpen = dropDownMenu.classList.toggle('open');

        toggleBtnIcon.classList = isOpen
            ? 'fa-solid fa-xmark'
            : 'fa-solid fa-bars'
        }


        //SEARCH
        function clearPlaceholder(input) {
        input.placeholder = '';
        }

          
       
       // ALERT BOX
        function fadeOutAlerts() {
            // Get all elements with the class 'alert'
            var alertBoxes = document.querySelectorAll('.alert');
    
            // Loop through each alert box
            alertBoxes.forEach(function(alertBox) {
                // Set a timeout function to fade out the alert box after 2 seconds
                setTimeout(function() {
                    alertBox.style.transition = 'opacity 1s ease-in-out';
                    alertBox.style.opacity = '0';
                    // After the fade out animation completes, remove the alert box from the DOM
                    setTimeout(function() {
                        alertBox.remove();
                    }, 1000); // Wait for 1 second (same duration as the transition) before removing
                }, 2500); // 2000 milliseconds = 2 seconds
            });
        }
    
        // Call the fadeOutAlerts function when the page is loaded
        window.onload = function() {
            fadeOutAlerts();
        };

        
       