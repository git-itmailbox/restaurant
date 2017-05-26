<tr>
    <td> {{$transaction->getSatoshiSumm() }}  </td>
    <td> {{$transaction->updated_at }}  </td>
    <td> {{($transaction->confirmed)? "Подтвержденa" : "Не Подтвержденa" }}  </td>
    <td> {{$transaction->transaction_num }}  </td>
</tr>

