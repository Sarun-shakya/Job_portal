// document.addEventListener("DOMContentLoaded", () => {
//   const menuItems = document.querySelectorAll(".menu-item");
//   const mainContent = document.getElementById("main-content");

//   menuItems.forEach(item => {
//     item.addEventListener("click", e => {
//       e.preventDefault();

//       menuItems.forEach(i => i.classList.remove("active"));
//       item.classList.add("active");

//       const page = item.getAttribute("data-page");

//       fetch(`content/${page}.php`)
//         .then(res => res.text())
//         .then(data => {
//           mainContent.style.opacity = 0;
//           setTimeout(() => {
//             mainContent.innerHTML = data;
//             mainContent.style.opacity = 1;

//             initDynamicScripts(); // ✅ Only here
//           }, 200);
//         })
//         .catch(err => {
//           mainContent.innerHTML = `<p style="color:red;">Error loading page.</p>`;
//           console.error(err);
//         });
//     });
//   });
// });

// function initDynamicScripts() {
//   const editorContainer = document.getElementById("editor");
//   const toolbarContainer = document.getElementById("toolbar");
//   const form = document.getElementById("jobForm");
//   const hiddenDescription = document.getElementById("description");

//   if (editorContainer && toolbarContainer && form && hiddenDescription) {
//     // Destroy old instance if exists
//     if (window.quillInstance) {
//       window.quillInstance = null;
//       editorContainer.innerHTML = "";
//     }

//     window.quillInstance = new Quill(editorContainer, {
//       modules: { toolbar: toolbarContainer },
//       placeholder: "Enter job description here...",
//       theme: "snow"
//     });

//     form.addEventListener("submit", function () {
//       hiddenDescription.value = window.quillInstance.root.innerHTML;
//     });

//     window.quillInstance.focus();
//   }
// }


const menuBtn = document.getElementById('menu-btn');
const sidebar = document.getElementById('sidebar');
const main = document.getElementById('main');

// Create overlay
const overlay = document.createElement('div');
overlay.classList.add('sidebar-overlay');
document.body.appendChild(overlay);

menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
    main.classList.toggle('sidebar-open');
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
    main.classList.remove('sidebar-open');
});

// Close sidebar on window resize (if desktop)
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        main.classList.remove('sidebar-open');
    }
});
