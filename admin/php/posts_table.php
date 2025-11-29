<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../php/db_config.php';
?>  
           
           <div id="posts" class="tab-content">
                <h2 class="text-3xl font-bold mb-4">Manage Posts</h2>

                <div class="flex gap-4 mb-4">
                    <button class="post-category-tab px-4 py-2 bg-[#f4f1e8] border border-[#131313] active"
                        data-category="timeless">Timeless Media</button>
                    <button class="post-category-tab px-4 py-2 bg-[#f4f1e8] border border-[#131313]"
                        data-category="oldny">Old New York Times</button>
                    <button class="post-category-tab px-4 py-2 bg-[#f4f1e8] border border-[#131313]"
                        data-category="cultural">Cultural Echoes</button>
                </div>

                <div class="overflow-x-auto">
                    <table id="post-table" class="mb-12">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="post-tbody">
                            <?php
                                $query = "SELECT posts.*, users.name 
                                        FROM posts 
                                        JOIN users ON posts.user_id = users.user_id
                                        ORDER BY posts.created_at DESC";

                                $result = $conn->query($query);

                                while ($row = $result->fetch_assoc()):
                                ?>
                                <tr data-category="<?= $row['category'] ?>">
                                    <td><?= htmlspecialchars($row['title']); ?></td>
                                    <td><?= htmlspecialchars($row['name']); ?></td>
                                    <td><?= ucfirst($row['category']); ?></td>

                                    <td>
                                        <form action="php/posts_process.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="post_id" value="<?= $row['post_id'] ?>">
                                            <input type="hidden" name="action" value="approve">
                                            <button class="bg-green-700 text-white px-2 py-1 text-sm"
                                                <?= $row['status'] === 'approved' ? 'disabled' : '' ?>>
                                                <?= $row['status'] === 'approved' ? 'Approved' : 'Approve' ?>
                                            </button>
                                        </form>

                                        <form action="php/posts_process.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="post_id" value="<?= $row['post_id'] ?>">
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
