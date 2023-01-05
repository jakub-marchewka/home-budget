export class Bill
{
    constructor()
    {
        this.createBill();
    }
    createBill()
    {
        $('.addBillModalButton').click(function () {
            $('#billModal').modal('show');
        });
        $('.addBillModalCloseButton').click(function () {
            $('#billModal').modal('hide');
        });
    }

}