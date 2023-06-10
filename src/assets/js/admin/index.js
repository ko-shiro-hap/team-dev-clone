'use strict';

const API_DEFINITION_PAGE_PATH = '../db/api/getData.php';

// 初回読み込み時
document.addEventListener('DOMContentLoaded', async () => {

  const clientData = await fetchData(API_DEFINITION_PAGE_PATH, 'SELECT id, company_name, service_name, post_period FROM clients');
  const entryData = await fetchData(API_DEFINITION_PAGE_PATH, 'SELECT client_id FROM entries');

  clientData.forEach((client) => {
    client.entry_count = 0;
    if(entryData.length !== 0) {
      entryData.forEach((entry) => {
        if(entry.client_id == client.id) {
          client.entry_count++;
        }
      });
    }
  });

  processAdminPage(clientData);
});


// クライアントページの一連の処理
const processAdminPage = (clientData) => {
  const formatPostPeriod = (postPeriod) => {
    return Number(postPeriod.replace('-', '').replace('-', ''));
  }


  const clientCount = clientData.length;
  let activeCount = 0;
  const today = new Date();
  const formattedDate = Number(`${today.getFullYear()}${(today.getMonth()+1).toString().padStart(2, '0')}${today.getDate().toString().padStart(2, '0')}`.replace(/\n|\r/g, ''));

  if(clientCount !== 0) {
    clientData.forEach((client) => {
      if(formatPostPeriod(client.post_period) >= formattedDate) {
        activeCount++;
      }
    });
  }


  // クライアント一覧のヘッダーの中身を作成
  const createClientListHeaderContent = () => {
    const clientCountContainer = document.getElementById('client-count');
    const activeCountContainer = document.getElementById('active-count');

    clientCountContainer.innerHTML = clientCount;
    activeCountContainer.innerHTML = activeCount;
  }

  // エントリー一覧のテーブルを作成
  const createClientListTableData = () => {
    const clientListTable = document.getElementById('client-list-table');

    if(clientData.length !== 0) {
      const clientListTableHtml = clientData.map((client) => {
        let isActive;

        if(formatPostPeriod(client.post_period) >= formattedDate) {
          isActive = '掲載中';
        } else {
          isActive = '掲載終了';
        }

        return `
        <tr>
          <td>${client.company_name}</td>
          <td>${client.service_name}</td>
          <td>${client.post_period.replace('-', '/').replace('-', '/')}まで</td>
          <td>${isActive}</td>
          <td>
            ${client.entry_count}件
            <a href="./client/?id=${client.id}">詳細</a>
          </td>
        </tr>`
      }).join('');

      clientListTable.insertAdjacentHTML('beforeend', clientListTableHtml);
    } else {
      clientListTable.insertAdjacentHTML('beforeend', '<tr><td colspan="9">クライアントが存在しません</td></tr>');
    }
  }

  createClientListHeaderContent();
  createClientListTableData();
}
