import './bootstrap';
import Swal from 'sweetalert2'
import Axios from 'axios';
window.axios = Axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


window.Swal = Swal;


document.querySelectorAll(".delete-form").forEach(el => {
    el.addEventListener('submit', (e) => {
        e.preventDefault();
        Swal.fire({
            title: 'Anda yakin?',
            text: "Anda tidak dapat membatalkan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                el.submit();
            }
        })

    });
});

// sending chat
const messageForm = document.getElementById("message-form");
if (messageForm) {
    
        messageForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const message = document.getElementById("message-input").value;
            const counseling_id = document.getElementById("counseling_id").value;
            
            Axios.post("/admin/counselings/messages", { message, counseling_id }).then(
                (response) => {
                    document.getElementById("message-input").value = "";
                    document.getElementById("message-input").focus();
                    console.log('should empty')
                    getMessages(counseling_id);
                    
                }
            );
        });
}

// get all messages
function getMessages(counseling_id) {
    const messageContainer = document.querySelector(".messages-display");
    
    Axios.get("/admin/counselings/messages/items", { params: { counseling_id } }).then((response) => {
        if (response.data) {
            messageContainer.innerHTML = response.data;

            
        }
        
    });
}

// interval get messages


const messageDisplay = document.querySelector(".messages-display");
if ( messageDisplay ) {
    let intervalId = setInterval(() => {
        const counselingIdElement = document.getElementById("counseling_id");
        if (counselingIdElement) {
            const counseling_id = counselingIdElement.value;
            getMessages(counseling_id);
        }
        

        if (!messageDisplay.matches(":hover")) {
            messageDisplay.scrollTop = messageDisplay.scrollHeight;
        }
    }, 2000);
    
}

// Edit role
document.querySelectorAll(".button-edit-role").forEach(el => {
    el.addEventListener('click', (e) => {
        e.preventDefault();
        console.log(el.getAttribute('data-id'));
        let id = el.getAttribute('data-id');
        let tr = document.querySelector(`tr.role-${id}`);
        let formEdit = tr.querySelector(".edit-role");
        let roleDisplay = tr.querySelector(".display-role-name");

        formEdit.classList.toggle('hidden');
        formEdit.querySelector('input[name="name"]').focus();
        formEdit.querySelector('input[name="name"]').setSelectionRange(-1, -1);
        roleDisplay.classList.toggle('hidden');
    });
});


// Function to send a POST request using Axios
const analyzeMessage = async (message) => {
    try {
        
        const messageData = { message: message };       
        const response = await axios.post('/admin/analyze-message', messageData);

        // Handle the response
        console.log('Response:', response.data);
    } catch (error) {
        // Handle any errors
        console.error('Error analyzing message:', error.response ? error.response.data : error.message);
    }
};

// Call the function to send the request

