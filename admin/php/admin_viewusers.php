<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../php/db_config.php';
?>  

            <div id="users" class="tab-content">
                <h2 class="text-3xl font-bold mb-4">Manage Users</h2>

                <div class="flex gap-4 mb-4">
                    <button class="user-role-tab px-4 py-2 bg-[#f4f1e8] border border-[#131313] active"
                        data-role="storyteller">Storytellers</button>
                    <button class="user-role-tab px-4 py-2 bg-[#f4f1e8] border border-[#131313]"
                        data-role="editor">Editors</button>
                    <button class="user-role-tab px-4 py-2 bg-[#f4f1e8] border border-[#131313]"
                        data-role="historian">Historians</button>
                </div>

                <div class="overflow-x-auto">
                    <table id="user-table" class="mb-12">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                            <tbody id="user-tbody">
                                <?php
                                $query = "SELECT user_id, name, email, role FROM users ORDER BY name ASC";
                                $result = $conn->query($query);

                                while ($row = $result->fetch_assoc()):
                                ?>
                                    <tr data-role="<?= htmlspecialchars($row['role']); ?>">
                                        <td><?= htmlspecialchars($row['name']); ?></td>
                                        <td><?= htmlspecialchars($row['email']); ?></td>
                                        <td><?= ucfirst(htmlspecialchars($row['role'])); ?></td>

                                        <td>
                                            <form action="php/admin_viewusersProcess.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <button class="bg-red-700 text-white px-2 py-1 text-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                    </table>
                </div>
            </div>

            
