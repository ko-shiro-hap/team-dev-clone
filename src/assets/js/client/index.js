'use strict';

const API_DEFINITION_PAGE_PATH = '../db/api/getData.php';

// 初回読み込み時
document.addEventListener('DOMContentLoaded', async () => {

  const inputOfMonth = document.getElementById('input-of-month');
  const selectedMonthSubmitButton = document.getElementById('selected-month-submit');
  // 月を選択したらsubmitして、クエリパラメーターを付与する
  inputOfMonth.addEventListener('change', () => {
    selectedMonthSubmitButton.click();
  });

  const selectedMonth = inputOfMonth.value;

  const clientData = await fetchData(API_DEFINITION_PAGE_PATH, `SELECT * FROM clients WHERE id = ${loginUserId}`);
  const entryData = await fetchData(API_DEFINITION_PAGE_PATH, `SELECT * FROM entries WHERE client_id = ${loginUserId} AND DATE_FORMAT(created_at, '%Y-%m') = '${selectedMonth}'`);
  const sexesData = await fetchData(API_DEFINITION_PAGE_PATH, 'SELECT * FROM sexes');

  if(entryData !== 0) {
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
    const postPeriodContainer = document.getElementById('post-period');

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

    postPeriodContainer.innerHTML = `掲載期間: ${clientData.post_period}まで`;
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


  // csvダウンロードボタンを押したらcsvをダウンロードする
  function downloadCsv() {
    let filteredData = entryData;
    const activeFilterInput = document.getElementById('active-filter');

    // is_active === 1 のデータをフィルタリング
    if(activeFilterInput.checked) {
      filteredData = entryData.filter(item => item.is_active === 1);
    }

    // client_id, is_active, updated_at, sex_id を除外
    const keysToRemove = ['client_id', 'is_active', 'updated_at', 'sex_id'];
    const cleanedData = filteredData.map(item => {
      const newItem = { ...item };
      keysToRemove.forEach(key => {
        delete newItem[key];
      });
      return newItem;
    });

    // CSV形式に変換
    const headers = Object.keys(cleanedData[0]);
    const csvRows = cleanedData.map(item => headers.map(header => JSON.stringify(item[header])).join(','));
    csvRows.unshift(headers.join(','));
    const csvData = csvRows.join('\r\n');

    // CSVファイルをダウンロード
    const link = document.createElement('a');
    link.href = URL.createObjectURL(new Blob([csvData], { type: 'text/csv;charset=utf-8;' }));
    link.download = 'entryData.csv';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }

  const downloadCsvButton = document.getElementById('download-csv');
  downloadCsvButton.addEventListener('click', downloadCsv);

  displayServiceName();
  createEntryListHeaderContent();
  createEntryListTableData();
}
