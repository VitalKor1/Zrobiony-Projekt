const imageInput = document.getElementById('imageUpload');
const previewImage = document.getElementById('previewImage');
const removeImage = document.getElementById('removeImage');

imageInput.addEventListener('change', function () {
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
            removeImage.style.display = "flex";
        };

        reader.readAsDataURL(file);
    }
});
const tagSelect = document.getElementById('tagSelect');
const selectedTagsContainer = document.querySelector('.selectedTags');

let selectedTags = [];

tagSelect.addEventListener('change', () => {
    const value = tagSelect.value;

    if (value && !selectedTags.includes(value)) {
        selectedTags.push(value);
        renderTags();
    }

    tagSelect.value = ""; 
});

function renderTags() {
    selectedTagsContainer.innerHTML = "";

    selectedTags.forEach(tag => {
        const el = document.createElement('span');
        el.classList.add('tag');
        el.textContent = tag;


        el.addEventListener('click', () => {
            selectedTags = selectedTags.filter(t => t !== tag);
            renderTags();
        });

        selectedTagsContainer.appendChild(el);
    });
}
removeImage.addEventListener('click', () => {
    previewImage.src = "";
    previewImage.style.display = "none";

    imageInput.value = ""; 
    removeImage.style.display = "none";
});

const postBtn = document.querySelector('.postBtn');

postBtn.addEventListener('click', () => {

});

const logoname = document.querySelector(".LogoName");

logoname.addEventListener('click', function(){
    window.location.href = "index.php";
})
