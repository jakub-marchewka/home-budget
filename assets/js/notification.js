import tab from "bootstrap/js/src/tab";
import {Property} from "./property";

export class Notification
{
    constructor()
    {
        Notification.createNotification();
        Notification.deleteNotification()
    }

    static createNotification()
    {
        $('.addNotificationButton').click(function () {
            $('#notificationModal').modal('show');
        });
        $('.addNotificationModalCloseButton').click(function () {
            $('#notificationModal').modal('hide');
        });

        $('.notificationForm').submit(function (event) {
            event.preventDefault();
            const form = $(this);
            const submitButton = $('.notificationCreateSubmitButton');
            submitButton.attr('disabled', true);
            let url = "/portal/notification/create";
            $.ajax({
                method: "POST",
                url: url,
                data: form.serialize(),
                success: (response) => {
                    if (response.status == 'success') {
                        $('#notificationModal').modal('hide');
                        Notification.refreshTable();
                        submitButton.removeAttr('disabled');
                        Notification.clearForm();
                    } else {
                        $('.modal-body').html(response.form);
                        Notification.createNotification();
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
        const table = $('.notification-table-wrap');
        $.ajax({
            method: "GET",
            url: "/portal/notification/table",
            success: (response) => {
                table.fadeOut(function () {
                    table.html(response);
                    Notification.deleteNotification();
                    table.fadeIn();
                });
            },
            error: () => {
                flasher.error('Wystąpił błąd.');
            }
        })
    }

    static clearForm()
    {
        $('#notification_name').val('');
        $('#notification_day').val('');
        $('#notification_description').val('');
    }

    static deleteNotification()
    {
        $('.deleteNotificationButton').click(function () {
            const notificationId = $(this).attr('notificationId');
            $.ajax({
                method: "POST",
                url: "/portal/notification/delete/"+notificationId,
                success: (response) => {
                    if (response.status === 'success') {
                        Notification.refreshTable();
                    } else {
                        flasher.error('Wystąpił błąd.');
                    }
                },
                error: () => {
                    flasher.error('Wystąpił błąd.');
                }
            })
        })
    }
}