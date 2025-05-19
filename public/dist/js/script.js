document.addEventListener("DOMContentLoaded", function () {
    // Section Navigation Highlighting
    const sections = document.querySelectorAll("section[id], header[id]");
    const navLinks = document.querySelectorAll(".nav-link");

    function setActiveLinkByHash() {
        const hash = window.location.hash || "#home";
        navLinks.forEach(link => link.classList.remove("active"));
        const activeLink = Array.from(navLinks).find(link => link.getAttribute("href") === hash);
        if (activeLink) {
            activeLink.classList.add("active");
        } else {
            const homeLink = Array.from(navLinks).find(link => link.getAttribute("href") === "#home");
            if (homeLink) homeLink.classList.add("active");
        }
    }

    function onScroll() {
        const scrollPos = window.scrollY + 100;
        let currentSectionFound = false;

        sections.forEach(section => {
            if (scrollPos >= section.offsetTop && scrollPos < section.offsetTop + section.offsetHeight) {
                navLinks.forEach(link => link.classList.remove("active"));
                navLinks.forEach(link => {
                    if (link.getAttribute("href").includes(section.getAttribute("id"))) {
                        link.classList.add("active");
                    }
                });
                currentSectionFound = true;
            }
        });

        if (!currentSectionFound && scrollPos < 200) {
            navLinks.forEach(link => link.classList.remove("active"));
            const homeLink = Array.from(navLinks).find(link => link.getAttribute("href") === "#home");
            if (homeLink) homeLink.classList.add("active");
        }
    }

    window.addEventListener("load", setActiveLinkByHash);
    window.addEventListener("scroll", onScroll);
    window.addEventListener("hashchange", setActiveLinkByHash);

    // Promo Modal: Populate content dynamically
    const promoModal = document.getElementById('promoModal');
    if (promoModal) {
        promoModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const title = button.getAttribute('data-title') || '';
            const content = button.getAttribute('data-content') || '';
            const image = button.getAttribute('data-image') || '';

            document.getElementById('promoModalTitle').textContent = title;
            document.getElementById('promoModalContent').textContent = content;
            document.getElementById('promoModalImg').src = image;
            document.getElementById('promoModalImg').alt = title;
        });
    }

    // Fullscreen Image Modal Logic
    document.querySelectorAll('.promo-card img').forEach(img => {
        img.style.cursor = "pointer";
        img.addEventListener('click', () => {
            const fullImage = document.getElementById('fullImage');
            fullImage.src = img.src;
            fullImage.alt = img.alt;
            const fullImageModal = new bootstrap.Modal(document.getElementById('fullImageModal'));
            fullImageModal.show();
        });
    });

    // Account/Login Modal
    const accountBtn = document.getElementById('accountBtn');
    const loginModalInstance = new bootstrap.Modal(document.getElementById('loginModal'));

    if (accountBtn) {
        accountBtn.addEventListener('click', () => {
            loginModalInstance.show();
        });
    }

    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const role = document.getElementById('loginRole').value;
            const email = document.getElementById('loginEmail');
            const password = document.getElementById('loginPassword');
            let valid = true;

            if (!email.value || !email.checkValidity()) {
                email.classList.add('is-invalid');
                valid = false;
            } else {
                email.classList.remove('is-invalid');
            }

            if (!password.value) {
                password.classList.add('is-invalid');
                valid = false;
            } else {
                password.classList.remove('is-invalid');
            }

            if (!valid) return;

            alert('This is a demo login. In a real application, you would handle authentication here.');
            bootstrap.Modal.getInstance(document.getElementById('loginModal')).hide();
        });
    }

    // Booking Form Submission
    const bookingForm = document.querySelector("#booking form");
    if (bookingForm) {
        bookingForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const from = document.getElementById("from");
            const to = document.getElementById("to");
            const date = document.getElementById("date");
            const passenger = document.getElementById("passenger");

            let valid = true;

            [from, to, date, passenger].forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add("is-invalid");
                    valid = false;
                } else {
                    input.classList.remove("is-invalid");
                }
            });

            if (from.value.trim().toLowerCase() === to.value.trim().toLowerCase()) {
                alert("Origin and destination cannot be the same.");
                valid = false;
            }

            if (!valid) return;

            alert(`Demo Booking:\nFrom: ${from.value}\nTo: ${to.value}\nDate: ${date.value}\nPassengers: ${passenger.value}\n\nThis is a demo. Booking is not functional yet.`);
            
            bookingForm.reset(); // Optional
        });
    }

    // Lazy Load Videos
    const videos = document.querySelectorAll('video[data-src]');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const video = entry.target;
                video.src = video.dataset.src;
                observer.unobserve(video);
            }
        });
    });
    videos.forEach(video => observer.observe(video));
});