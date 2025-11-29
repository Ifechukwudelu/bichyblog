<?php if(!empty($message)): ?>
<div id="msgBox"
     class="fixed top-[10rem] right-5 bg-[#f4f1e8] text-[#131313] border-2 border-[#131313] px-5 py-3 rounded shadow-[4px_4px_0_#131313] transform transition-all duration-300 opacity-0 -translate-y-2 font-serif font-semibold">
    <?= $message ?>
</div>

<script>
    const box = document.getElementById("msgBox");

    setTimeout(() => {
        box.classList.remove("opacity-0", "-translate-y-2");
        box.classList.add("opacity-100", "translate-y-0");
    }, 50);

    setTimeout(() => {
        box.classList.remove("opacity-100", "translate-y-0");
        box.classList.add("opacity-0", "-translate-y-2");
    }, 2000);

    <?php if (!empty($redirectAfter)): ?>
    setTimeout(() => {
        window.location.href = "<?= $redirectAfter ?>";
    }, 2000);
    <?php endif; ?>
</script>
<?php endif;?>