const $ = require('jquery');

export class Property
{
    constructor()
    {
        this.createProperty();
    }

    createProperty()
    {
        $('.addPropertyModalButton').click(function () {
            $('#propertyModal').modal('show');
        });
        $('.addPropertyModalCloseButton').click(function () {
            $('#propertyModal').modal('hide');
        });
        $('.addPropertyModalAddButton').click(function () {
            const name = $('#name').val();
            if (4 > name.length) {
                flasher.error("Nazwa jest za krótka.");
            } else {
                $('.addPropertyModalAddButton').attr('disabled', true);
                $.ajax({
                    method: "POST",
                    url: "/portal/property/create",
                    data: { name: name },
                    success: (response) => {
                        if (response.status == 'success') {
                            $('#propertyModal').modal('hide');
                            flasher.success('Nieruchomość została dodana.');
                            $('#name').val('');
                            $('.addPropertyModalAddButton').removeAttr('disabled');
                            let table = $('.property-table-wrapp');
                            table.fadeOut(function () {
                                table.html(response.table);
                                table.fadeIn();
                            });
                        } else {
                            flasher.error('Wystąpił błąd.');
                        }
                    },
                    error: () => {
                        flasher.error('Wystąpił błąd.');
                    }
                })
            }
        });
    }
}