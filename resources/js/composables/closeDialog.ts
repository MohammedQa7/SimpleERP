
export function closeDialog(emit: any) {
    const dialogContent = document.querySelector('.radix-dialog-content');
    console.log(dialogContent);

    if (dialogContent) {
        dialogContent.setAttribute('data-state', 'closed');
        setTimeout(() => {
            emit('Close', false);
        }, 100);
    }
}
