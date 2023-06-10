'use strict';

const API_DEFINITION_PAGE_PATH = '../../db/api/getData.php';

// 初回読み込み時
document.addEventListener('DOMContentLoaded', async () => {
  // ここはログイン機能ができたら変更する
  const url = new URL(window.location.href);
  const queryParam = url.searchParams;
  const selectedClientId = Number(queryParam.get('id'));


  const inputOfMonth = document.getElementById('input-of-month');
  const selectedMonthSubmitButton = document.getElementById('selected-month-submit');
  // 月を選択したらsubmitして、クエリパラメーターを付与する
  inputOfMonth.addEventListener('change', () => {
    selectedMonthSubmitButton.click();
  });

  const selectedMonth = inputOfMonth.value;

  const clientData = await fetchData(API_DEFINITION_PAGE_PATH, `SELECT * FROM clients WHERE id = ${selectedClientId}`);
  const entryData = await fetchData(API_DEFINITION_PAGE_PATH, `SELECT * FROM entries WHERE client_id = ${selectedClientId} AND DATE_FORMAT(created_at, '%Y-%m') = '${selectedMonth}'`);
  const sexesData = await fetchData(API_DEFINITION_PAGE_PATH, 'SELECT * FROM sexes');

  if(entryData != 0) {
    entryData.forEach((entry) => {
      // entryDataにsex_nameを追加
      sexesData.forEach((sex) => {
        if(entry.sex_id === sex.id) {
          entry.sex_name = sex.sex;
        }
      });
    });
  }

  processClientPage(clientData[0], entryData);
});


// クライアントページの一連の処理
const processClientPage = (clientData, entryData) => {
  // サービス名を表示
  const displayServiceName = () => {
    const serviceNameContainer = document.getElementById('service-name-container');

    serviceNameContainer.innerHTML = `サービス名：${clientData.service_name}`;
  }


  // エントリー一覧のヘッダーの中身を作成
  const createEntryListHeaderContent = () => {
    const entryCountContainer = document.getElementById('entry-count');
    const invalidCountContainer = document.getElementById('invalid-count');
    const billableCountContainer = document.getElementById('billable-count');

    let entryCount = 0;
    let invalidCount = 0;

    if(entryData !== 0) {
      entryCount = entryData.length;
      entryData.forEach((entry) => {
        if(entry.is_active === 0) {
          invalidCount++;
        }
      });
    }

    entryCountContainer.innerHTML = entryCount;
    invalidCountContainer.innerHTML = invalidCount;
    billableCountContainer.innerHTML = entryCount - invalidCount;
  }


  // エントリー一覧のテーブルを作成
  const createEntryListTableData = () => {
    const entryListTable = document.getElementById('entry-list-table');

    if(entryData !== 0) {
      const entryListTableHtml = entryData.map((entry) => {
        return `
        <tr class="${entry.is_active == 0 && 'entries-table-not-active'}">
        <td>${entry.id}</td>
        <td>${entry.student_name}</td>
        <td>${entry.sex_name}</td>
        <td>${entry.email}</td>
        <td>${entry.phone_number}</td>
        <td>${entry.residence_prefecture}</td>
        <td>${entry.univ_dept_major}</td>
        <td>${entry.graduation_year}年度</td>
        <td>${entry.created_at.substring(0, 10)}</td>
        </tr>`
      }).join('');

      entryListTable.insertAdjacentHTML('beforeend', entryListTableHtml);
    } else {
      entryListTable.insertAdjacentHTML('beforeend', '<tr><td colspan="9">エントリーがありません</td></tr>');
    }
  }


  displayServiceName();
  createEntryListHeaderContent();
  createEntryListTableData();
}
