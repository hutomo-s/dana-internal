<h1>Exception Paper</h1>

<p>Date of Request: <?= date('Y-m-d', strtotime($ep_data->created_at)) ?></p>

<p>Purchase Title: <?= $ep_data->purchase_title ?></p>

<p>PR Number: <?= $ep_data->pr_number ?></p>

<p>The reason for not following tender/pitching process: <?= $ep_data->exception_reason ?></p>

<p>Attachment(s):</p>

<ul>
    <?php foreach($ep_attachments_reason as $epar): ?>
        <li>
            <a href="<?= base_url($epar->attachment_fullpath) ?>" target="_blank">
                <?= base_url($epar->attachment_fullpath) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<p>Impact to DANA as Organization if we are failed to perform the agreement as soon as possible: <?= $ep_data->exception_impact ?></p>

<p>Attachment(s):</p>

<ul>
    <?php foreach($ep_attachments_impact as $epai): ?>
        <li>
            <a href="<?= base_url($epai->attachment_fullpath) ?>" target="_blank">
                <?= base_url($epai->attachment_fullpath) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<p>Due Date for the ordering confirmation: <?= $ep_data->request_due_date ?></p>

<p>Cost to proceed the order: <?= $ep_data->request_cost_currency ?> <?= number_format($ep_data->request_cost_amount, 2, '.', ',') ?></p>

<p><i>Requestor Statement: </i></p>
<p><i>Hereby I declare that this request <u>to justify</u> the urgency, without any conflict of interest to the selected vendor.</i></p>

<table>
    <tr>
        <td width="150px;">Requestor</td>
        <td width="150px;">Line Manager</td>
        <td width="150px;">Excom I</td>
        <td width="150px;">Excom II</td>
        <?php if($ep_history_list['ceo']['name']): ?>
            <td width="150px;">CEO</td>
        <?php endif ?>
    </tr>
    <tr>
        <td><img src="<?= $ep_history_list['requestor']['signature'] ?>" style="max-width: 150px; height: auto;"></td>
        <td><img src="<?= $ep_history_list['line_manager']['signature'] ?>" style="max-width: 150px; height: auto;"></td>
        <td><img src="<?= $ep_history_list['excom_1']['signature'] ?>" style="max-width: 150px; height: auto;"></td>
        <td><img src="<?= $ep_history_list['excom_2']['signature'] ?>" style="max-width: 150px; height: auto;"></td>
        <?php if($ep_history_list['ceo']['name']): ?>
        <td><img src="<?= $ep_history_list['ceo']['signature'] ?>" style="max-width: 150px; height: auto;"></td>
        <?php endif ?>
    </tr>
    <tr>
        <td><?= $ep_history_list['requestor']['name'] ?? '' ?></td>
        <td><?= $ep_history_list['line_manager']['name'] ?? '' ?></td>
        <td><?= $ep_history_list['excom_1']['name'] ?? '' ?></td>
        <td><?= $ep_history_list['excom_2']['name'] ?? '' ?></td>
        <?php if($ep_history_list['ceo']['name']): ?>
        <td><?= $ep_history_list['ceo']['name'] ?? '' ?></td>
        <?php endif ?>
    </tr>
    
</table>