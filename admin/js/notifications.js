$(document).ready(function() {
    // Function to fetch notifications
   
    function fetchNotifications() {
        $.ajax({
            url: 'partials/fetch_notifications.php', // Adjust this to the URL of your server-side script
            method: 'GET',
            dataType: 'json',
            success: function(notifications) {
                if (notifications.length > 0) {
                    displayNotifications(notifications);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching notifications:', error);
            }
        });
    }

   // Function to display notifications
    function displayNotifications(notifications) {
    const notificationsContainer = $('#notificationsContainer'); // Adjust this selector to your container's ID
    notificationsContainer.empty(); // Clear out any existing notifications

    notifications.forEach(function(notification) {
        const formattedDate = formatDate(notification.notification_date);
        const notificationElement = $(`
            <a href="${notification.notification_link}" class="dropdown-item">
                <div class="media">
                    <div class="mr-3">
                        <i class="fas fa-dollar-sign fa text-primary"></i> <!-- Font Awesome Dollar Sign Icon -->
                    </div>
                    <div class="media-body">
                        <h3 class="dropdown-item-title">
                            <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                        </h3>
                        <p class="text-sm">${notification.notification_detail}</p>
                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> ${formattedDate}</p>
                    </div>
                </div>
            </a>
        `);
        notificationsContainer.append(notificationElement);
    });

    // Update the notification count
    $('#notificationsCount').text(notifications.length); // Adjust this selector to your notification count's ID
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0'); // getMonth() is zero-based
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }


    // Fetch notifications on document ready
    fetchNotifications();

    // Optionally, fetch notifications at regular intervals
    setInterval(fetchNotifications, 10000); // 10 seconds as an example
});
