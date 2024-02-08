function getStatusContract(endTime = '') {
    const endDate = new Date(endTime);
    const now = new Date();
    const days = Math.ceil((endDate - now) / (1000 * 60 * 60 * 24));
    let renderStatus = '';
    switch (true) {
        case days > 0 && days <= 30:
            renderStatus = '<span class="btn btn-warning">Hết hạn trong ' + days +
                ' ngày</span>';
            break;
        case days <= 0:
            renderStatus = '<span class="btn btn-danger">Hết hạn</span>';
            break;
        case days > 30:
            renderStatus = '<span class="btn btn-success">Còn hạn</span>';
            break;
        default:
            break;
    }

    return renderStatus;
}
