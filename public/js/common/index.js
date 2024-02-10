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

function getActive(active = '') {
    let renderActive = '';
    switch (active) {
        case 0:
            renderActive = '<span class="btn btn-danger">Không</span>';
            break;
        case 1:
            renderActive = '<span class="btn btn-success">Có</span>';
            break;
        default:
            break;
    }

    return renderActive;
}
