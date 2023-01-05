export class Bill
{
    constructor()
    {
        Bill.createBill();
        Bill.billUpdate();
    }
    static createBill()
    {
        $('.addBillModalButton').click(function () {
            $('#billModal').modal('show');
        });
        $('.addBillModalCloseButton').click(function () {
            $('#billModal').modal('hide');
        });

        $('.billForm').submit(function (event) {
            event.preventDefault();
            const form = $(this);
            const submitButton = $('.billCreateSubmitButton');
            submitButton.attr('disabled', true);
            let url = "/portal/bill/create";
            if (submitButton.hasClass('isUpdate')) {
                url = "/portal/bill/update/" + $('.modal-body').attr('billId');
            }
            $.ajax({
                method: "POST",
                url: url,
                data: form.serialize(),
                success: (response) => {
                    if (response.status == 'success') {
                        $('#billModal').modal('hide');
                        Bill.refreshTable();
                        submitButton.removeAttr('disabled');
                    } else {
                        $('.modal-body').html(response.form);
                        Bill.createBill();
                        submitButton.removeAttr('disabled');
                    }
                },
                error: () => {
                    flasher.error('Wystąpił błąd.');
                    submitButton.removeAttr('disabled');
                }
            })
        });
    }
    static refreshTable()
    {
        const table = $('.bill-table-wrap');
        $.ajax({
            method: "GET",
            url: "/portal/bill/table",
            success: (response) => {
                table.fadeOut(function () {
                    $('.bill-table-wrap').html(response);
                    table.fadeIn();
                    Bill.billUpdate();
                });
            },
            error: () => {
                flasher.error('Wystąpił błąd.');
            }
        })
    }

    static billUpdate()
    {
        $('.updateBillModal').click(function () {
            const billId = $(this).attr('billId');
            $('.modal-body').attr('billId', billId);
            $.ajax({
                method: "GET",
                url: "/portal/bill/update/" + billId,
                success: (response) => {
                    $('.modal-body').html(response.form);
                    Bill.createBill();
                    $('#billModal').modal('show');
                },
                error: () => {
                    flasher.error('Wystąpił błąd.');
                }
            })
        });
    }

    static clearForm()
    {

    }
}