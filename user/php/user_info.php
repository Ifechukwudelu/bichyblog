<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../php/db_config.php';

    if (!isset($user_id)) {
    $user_id = $_SESSION['user_id'] ?? null;
    }

$userInfo = [];

     $stmt = $conn->prepare(
         "SELECT name, email, username, password, role 
          FROM users 
          WHERE user_id = ? 
           "
     );

     $stmt->bind_param("i", $user_id);
     $stmt->execute();

     $userInfo = $stmt->get_result()->fetch_assoc();
     $stmt->close(); 
    

?>


<style>

@keyframes fadeInOld {
  from {
    opacity: 0;
    transform: scale(0.95) translateY(10px);
  }
  to {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}

.animate-fadeInOld {
  animation: fadeInOld 0.3s ease-out;
}
</style>
      
      
      <section id="details" class="tab-content card">
        <h2 class="text-2xl font-semibold mb-4">Personal Details</h2>
        <form action="user_allformsprocess.php" method="POST" class="space-y-4 max-w-md mx-auto">
          <input type="hidden" name="form_type" value="update_user">
          <div>
            <label>Name</label>
            <input type="text" name="fullname" class="w-full border border-[#131313] px-2 py-1" value="<?= htmlspecialchars($userInfo['name']); ?>" readonly>
          </div>

          <div>
            <label>Email</label>
            <input type="email"  name="email" class="w-full border border-[#131313] px-2 py-1" value="<?= htmlspecialchars($userInfo['email']); ?>" readonly>
          </div>

          <div>
            <label>Username</label>
            <input type="text" name="username" class="w-full border border-[#131313] px-2 py-1" value="<?= htmlspecialchars($userInfo['username']); ?>" readonly>
          </div>

          <div>
            <label>Password</label>
            <input type="text" name="password" class="w-full border border-[#131313] px-2 py-1" value="**************" readonly>
          </div>

          <div>
            <label>Role</label>
            <input type="text" class="w-full border border-[#131313] px-2 py-1" value="<?= htmlspecialchars($userInfo['role']); ?>" readonly>
          </div>

          <button type="button" onclick="openUpdateOverlay()" class="bg-[#131313] hover:bg-gray-800 text-white px-4 py-1 text-sm"> Update Details </button>

        </form>

      </section>

      <div id="updateOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden 
        items-center justify-center z-50">

      <div class="bg-[#f4f1e8] border-4 border-[#131313] shadow-[6px_6px_0_#131313]
              max-w-md w-full p-6 relative animate-fadeInOld">

    <button onclick="closeUpdateOverlay()"
      class="absolute top-2 right-2 bg-[#131313] text-white px-2 py-1 text-xs hover:bg-gray-800">
      ✕
    </button>

    <h2 class="text-xl font-bold font-serif mb-4">Update Your Details</h2>

    <form action="user_allformsprocess.php" method="POST" class="space-y-4">
      <input type="hidden" name="form_type" value="update_user">

      <div>
        <label class="font-semibold">Full Name</label>
        <input type="text" name="fullname" value="<?= htmlspecialchars($userInfo['name']); ?>"
          class="w-full border border-[#131313] bg-[#faf7ef] px-2 py-1">
      </div>

      <div>
        <label class="font-semibold">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($userInfo['email']); ?>"
          class="w-full border border-[#131313] bg-[#faf7ef] px-2 py-1">
      </div>

      <div>
        <label class="font-semibold">Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($userInfo['username']); ?>"
          class="w-full border border-[#131313] bg-[#faf7ef] px-2 py-1">
      </div>

      <div>
        <label class="font-semibold">Password</label>
        <input type="text" name="password" value="*********"
          class="w-full border border-[#131313] bg-[#faf7ef] px-2 py-1"
          placeholder="Leave empty to keep old password">
      </div>

      <div>
          <label for="role" class="font-semibold">Role</label>
          <select id="role" name="role" 
              class="w-full border border-[#131313] bg-[#faf7ef] px-2 py-1">
              <option ><?= htmlspecialchars($userInfo['role']); ?></option>
              <option value="storyteller">Storyteller</option>
              <option value="editor">Editor</option>
              <option value="Historian">Historian</option>
          </select>
      </div>

      <button type="submit"
        class="bg-[#131313] hover:bg-gray-800 text-white w-full py-2">
        Save Changes
      </button>
    </form>

  </div>
</div>

<script>
function openUpdateOverlay() {
    document.getElementById("updateOverlay").classList.remove("hidden");
}

function closeUpdateOverlay() {
    document.getElementById("updateOverlay").classList.add("hidden");
}
</script>