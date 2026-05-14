let postIdToDelete = null;
let cardToDelete = null;

const deleteModal = document.getElementById('deleteModal');
const confirmBtn = document.getElementById('confirmDelete');
const cancelBtn = document.getElementById('cancelDelete');

document.addEventListener("DOMContentLoaded", () => {
    
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("deletebutton")) {
            const card = e.target.closest(".card");
            const id = card?.getAttribute("data-id");

            if (id) {
                postIdToDelete = id;
                cardToDelete = card;
                if (deleteModal) deleteModal.style.display = 'flex';
            }
        }
    });

    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            closeDeleteModal();
        });
    }

    if (confirmBtn) {
        confirmBtn.addEventListener('click', () => {
            if (!postIdToDelete) return;

            fetch("delete.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id=" + encodeURIComponent(postIdToDelete)
            })
            .then(res => res.text())
            .then(data => {
                if (data.trim() === "OK") {
                    if (cardToDelete) cardToDelete.remove();
                    closeDeleteModal();
                } else {
                    alert("Ошибка: " + data);
                }
            })
            .catch(err => console.error(err));
        });
    }

    if (deleteModal) {
        deleteModal.addEventListener('click', (e) => {
            if (e.target === deleteModal) closeDeleteModal();
        });
    }

    function closeDeleteModal() {
        if (deleteModal) deleteModal.style.display = 'none';
        postIdToDelete = null;
        cardToDelete = null;
    }

    const logoname = document.querySelector(".LogoName");
    if (logoname) {
        logoname.addEventListener('click', () => {
            window.location.href = "index.php";
        });
    }

    const createBtn = document.querySelector(".crtpst");
    if (createBtn) {
        createBtn.addEventListener('click', () => {
            window.location.href = "addPost.php";
        });
    }

    const btnregist = document.querySelector(".btnregist");
    if (btnregist) {
        btnregist.addEventListener('click', () => {
            window.location.href = "rejestracja.php";
        });
    }

    const btnlogin = document.querySelector(".btnlogin");
    if (btnlogin) {
        btnlogin.addEventListener('click', () => {
            window.location.href = "login.php";
        });
    }

    const creatorLogo = document.querySelector('.creatorlogo');
    const settingsWindow = document.querySelector('.settingswindow');

    if (creatorLogo && settingsWindow) {
        creatorLogo.addEventListener('click', (e) => {
            settingsWindow.style.display = (settingsWindow.style.display === 'flex') ? 'none' : 'flex';
            e.stopPropagation();
        });

        document.addEventListener('click', (e) => {
            if (!settingsWindow.contains(e.target) && e.target !== creatorLogo) {
                settingsWindow.style.display = 'none';
            }
        });
    }

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("morinfo")) {
            const card = e.target.closest(".card");
            const text = card.querySelector(".card-info p")?.innerText || "";
            const imgTag = card.querySelector("img:not(.logoface)"); 
            const imgSrc = imgTag ? imgTag.getAttribute("src") : "";

            const url = `moreInfo.php?text=${encodeURIComponent(text)}&img=${encodeURIComponent(imgSrc)}`;
            window.location.href = url;
        }
    });

const profileButtons = document.querySelectorAll('.ulnav a');
profileButtons.forEach(btn => {
    if (btn.innerText.toLowerCase() === 'profiles' || btn.innerText.toLowerCase() === 'profile') {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            window.location.href = "profile.php";
        });
    }
});
});

function toggleLike(postId, btn) {
    const formData = new FormData();
    formData.append('id', postId);

    fetch('like.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "Error") {
            alert("Войдите в аккаунт!");
        } else {
            const countSpan = btn.querySelector('.likes-count');
            if (countSpan) countSpan.innerText = data.trim();
            btn.classList.toggle('liked');
        }
    })
    .catch(err => console.error(err));
}

const toggle = document.getElementById('theme-toggle');


function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
}

if (toggle) {
    toggle.addEventListener('change', function() {
        if (this.checked) {
            setTheme('dark');
        } else {
            setTheme('light');
        }
    });
}


const savedTheme = localStorage.getItem('theme') || 'light';
setTheme(savedTheme);
if (toggle) toggle.checked = (savedTheme === 'dark');

document.addEventListener('DOMContentLoaded', () => {
    const langToggle = document.getElementById('lang-toggle');
    
    function updateLanguage(lang) {
        const elements = document.querySelectorAll('[data-lang-en]');
        elements.forEach(el => {
            const translation = lang === 'pl' ? el.getAttribute('data-lang-pl') : el.getAttribute('data-lang-en');
            

            if (el.tagName === 'INPUT') {
                el.placeholder = translation;
            } else {
               
                el.textContent = translation;
            }
        });
        localStorage.setItem('language', lang);
    }

    if (langToggle) {
        langToggle.addEventListener('change', function() {
            updateLanguage(this.checked ? 'pl' : 'en');
        });
      
        const savedLang = localStorage.getItem('language') || 'en';
        langToggle.checked = (savedLang === 'pl');
        updateLanguage(savedLang);
    } else {
   
        updateLanguage(localStorage.getItem('language') || 'en');
    }

    
    const wipModal = document.getElementById('workInProgressModal');
    const closeBtn = document.getElementById('closeWipModal');


    if (closeBtn && wipModal) {
        closeBtn.addEventListener('click', () => {
            wipModal.style.display = 'none';
        });
    }


    if (wipModal) {
        window.addEventListener('click', (event) => {
            if (event.target === wipModal) {
                wipModal.style.display = 'none';
            }
        });
    }

    const likeButtons = document.querySelectorAll('.like-button');

    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const container = this.closest('.like-container');
            const countElement = container.querySelector('.likes-count');
            const heart = this.querySelector('.heart-icon');
            let count = parseInt(countElement.innerText);

            if (!this.classList.contains('active')) {

                this.classList.add('active');
                heart.innerText = '❤️';
                countElement.innerText = count + 1;
                countElement.style.color = '#e0245e';
            } else {

                this.classList.remove('active');
                heart.innerText = '🤍';
                countElement.innerText = count - 1;
                countElement.style.color = 'black';
            }
        });
    });
    const friendsBtn = document.getElementById('friendsBtn');
const friendsModal = document.getElementById('friendsModal');
const closeFriendsBtn = document.getElementById('closeFriendsModal');
const usersList = document.getElementById('usersList');

if (friendsBtn) {
    friendsBtn.addEventListener('click', (e) => {
        e.preventDefault();
        

        usersList.innerHTML = 'Loading...';
        friendsModal.style.display = 'flex';

        fetch('get_users.php')
            .then(response => response.json())
            .then(users => {
                usersList.innerHTML = ''; 
                if (users.length === 0) {
                    usersList.innerHTML = 'No users found.';
                    return;
                }

                users.map(user => {
                    const userRow = document.createElement('div');
                    userRow.style.cssText = 'display: flex; align-items: center; gap: 10px; margin-bottom: 10px; padding: 5px; border-bottom: 1px solid #eee;';
                    
                    const avatar = user.avatar ? user.avatar : 'img/face.jpg';
                    
                    userRow.innerHTML = `
                        <img src="${avatar}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        <span style="font-weight: bold;">${user.username}</span>
                    `;
                    usersList.appendChild(userRow);
                });
            })
            .catch(err => {
                usersList.innerHTML = 'Error loading users.';
                console.error(err);
            });
    });
}

if (closeFriendsBtn) {
    closeFriendsBtn.addEventListener('click', () => {
        friendsModal.style.display = 'none';
    });
}

window.addEventListener('click', (e) => {
    if (e.target === friendsModal) {
        friendsModal.style.display = 'none';
    }
});
});

const notReadyLinks = document.querySelectorAll('.not-ready');
const wipModal = document.getElementById('workInProgressModal');

notReadyLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault(); 
        wipModal.style.display = 'flex';
        

        const currentLang = localStorage.getItem('language') || 'en';
        updateLanguage(currentLang); 
    });
});