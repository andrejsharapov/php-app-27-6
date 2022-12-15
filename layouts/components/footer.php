<footer class="bg-white py-2 border-t-2">
    <p class="text-center">
        &copy; 2022 by Andrej Sharapov.
    </p>
</footer>

<script>
    const snackbar = document.querySelector(".snackbar");

    if (snackbar) {
        setTimeout(() => {
            snackbar.classList.add("hidden");
        }, 3000);
    }
</script>

</body>
</html>
