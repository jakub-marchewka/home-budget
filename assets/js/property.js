export class Property
{
    constructor()
    {
        this.createProperty();
        Property.changeCurrentProperty();
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
    static changeCurrentProperty()
    {
        $('.changeCurrentPropertyButton').click(function () {
            let icon = $(this);
            const oldIcon = $('.currentPropertyIcon');
            const propertyId = icon.attr('propertyId');
            if (icon.hasClass('currentPropertyIcon')) {
                flasher.info('To jest twoja aktualna nieruchomość.')
            } else {
                $.ajax({
                    method: "POST",
                    url: "/portal/property/current",
                    data: { propertyId: propertyId },
                    success: (response) => {
                        if (response.status == 'success') {
                            icon.fadeOut(function () {
                                icon.removeClass('fa-regular');
                                icon.addClass('fa-solid');
                                icon.addClass('currentPropertyIcon');
                                icon.removeClass('changeCurrentPropertyButton');
                                icon.fadeIn();
                            });
                            oldIcon.fadeOut(function () {
                                oldIcon.removeClass('fa-solid');
                                oldIcon.addClass('fa-regular');
                                oldIcon.addClass('changeCurrentPropertyButton');
                                oldIcon.removeClass('currentPropertyIcon');
                                oldIcon.fadeIn();
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