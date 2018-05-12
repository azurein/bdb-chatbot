<form action="https://bunga-dalam-bahaya.herokuapp.com/index.php/bunga/updateEvent/<?=$content_event['transaction_code']?>" method="POST" id="status_form">
    <table>
        <tr>
            <td>Status Laporan</td>
            <td>
                <select name="status" <?=$content_event['status'] == "cancel" || $content_event['status'] == "done" ? 'disabled' : ''?>>
                    <option value="pending" <?=$content_event['status'] == "pending" ? 'selected' : ''?>>Belum ditanggapi</option>
                    <option value="onprogress" <?=$content_event['status'] == "onprogress" ? 'selected' : ''?>>Sedang ditangani</option>
                    <option value="done" <?=$content_event['status'] == "done" ? 'selected' : ''?>>Sudah selesai</option>
                    <option value="cancel" <?=$content_event['status'] == "cancel" ? 'selected' : ''?>>Dibatalkan</option>
                </select>
            </td>
        </tr>
    </table>
</form>