<?php foreach ($khuyenmai as $item): ?> <tr>
        <td><?= $item["maKM"] ?></td>
        <td><?= $item["tenKM"] ?></td>
        <td><?= $item["noiDungChuongTrinh"] ?></td>
        <td><?= $item["phanTramKM"] ?>%</td>
        <td>
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editPromotionModal"
                onclick="document.getElementById('editMaKM').value='<?= $item['maKM'] ?>'; 
                document.getElementById('editTenKM').value='<?= $item['tenKM'] ?>'; 
                document.getElementById('editNoiDungChuongTrinh').value='<?= $item['noiDungChuongTrinh'] ?>'; 
                document.getElementById('editPhanTramKM').value='<?= $item['phanTramKM'] ?>';"> Sửa
            </button>
            <button onclick="return confirm('Bạn có chắc chắn muốn xóa khuyến mãi này không?')"
                type="submit" name="btXoa" value="<?= $item["maKM"] ?>" class="btn btn-danger">Xóa
            </button>
        </td>
    </tr> <?php endforeach; ?>