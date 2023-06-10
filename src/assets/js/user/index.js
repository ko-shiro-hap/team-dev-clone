'use strict';

const API_DEFINITION_PAGE_PATH = './db/api/getData.php';

let agentData = [];
let allAgentCount;
let keepAgentsId = [];
let keepButton = [];
let liftButton = [];

const searchInputs = document.querySelectorAll('.sidebar-input');
const areaSelectBox = document.getElementById('area-select');
const industrySelectBox = document.getElementById('industry-select');
const remoteAvailableCheckbox = document.getElementById('remote-available-checkbox');

// 初回読み込み時
document.addEventListener('DOMContentLoaded', async () => {
  agentData = await fetchData(API_DEFINITION_PAGE_PATH, 'SELECT * FROM clients WHERE post_period >= NOW()');
  allAgentCount = agentData.length;

  const existedAreaIds = await fetchData(API_DEFINITION_PAGE_PATH, 'SELECT area_id FROM clients');
  const existedIndustryIds = await fetchData(API_DEFINITION_PAGE_PATH, 'SELECT industry_id FROM client_industry');

  // agentDataとリレーションがあるarea_idとindustry_idを取得
  const areaIds = existedAreaIds.map(item => item.area_id);
  const industryIds = existedIndustryIds.map(item => item.industry_id);

  // area_idとindustry_idを取得して、areaとindustryのデータを取得
  const areaData = await fetchData(API_DEFINITION_PAGE_PATH, `SELECT * FROM areas WHERE id IN (${areaIds.join(',')})`);
  const industryData = await fetchData(API_DEFINITION_PAGE_PATH, `SELECT * FROM industries WHERE id IN (${industryIds.join(',')})`);

  if(agentData !== 0) {
    // client_industryテーブルのclient_idと一致するものを取得する
    const agentIndustrySqlQuery = `SELECT * FROM client_industry WHERE client_id IN (${agentData.map(item => item.id).join(',')})`;
    const agentIndustryData = await fetchData(API_DEFINITION_PAGE_PATH, agentIndustrySqlQuery);

    // agentDataにarea_nameとindustry_namesを追加
    agentData.forEach((item, index) => {
      const areaIndex = areaData.findIndex(area => area.id === item.area_id);
      agentData[index].area_name = areaData[areaIndex].name;

      const industryIds = agentIndustryData.filter(agentIndustry => agentIndustry.client_id === item.id).map(agentIndustry => agentIndustry.industry_id);
      const industryNames = industryData.filter(industry => industryIds.includes(industry.id)).map(industry => industry.name);
      agentData[index].industry_names = industryNames;
    })
  }

  createAgentDom(agentData);

  createSelectOptions(areaSelectBox, areaData);
  createSelectOptions(industrySelectBox, industryData);
});


// サイドバーの開閉
const sidebar = document.getElementById('sidebar');
const agentList = document.getElementById('agent-list');
const sidebarHeader = document.getElementById('sidebar-header');
const sidebarIcon = document.getElementById('sidebar-icon');
const sidebarBody = document.getElementById('sidebar-body');
const body = document.getElementById('body');


const sidebarToggle = () => {
  sidebarIcon.classList.toggle('sidebar-search-header-icon-open');
  sidebarBody.classList.toggle('sidebar-body-open');

  const sidebarHeight = sidebarBody.clientHeight;
  if(window.innerWidth >= 768) {
  agentList.style.marginTop = -sidebarHeight - 90 + 'px';
  } else {
  agentList.style.marginTop = -sidebarHeight + 'px';
  }
}

sidebarHeader.addEventListener('click', sidebarToggle);


// エージェント一覧のDOMを生成
const createAgentDom = (data) => {
  const agentContainer = document.getElementById('agent-container');
  agentContainer.innerHTML = '';

  if(data.length !== 0) {
  const listHtml = data.map(item => {
    const createButton = () => {
      if(keepAgentsId.includes(item.id)) {
        return `<button class="agent-item-list-button lift-button" value="${item.id}">解除</button>`;
      } else {
        return `<button class="agent-item-list-button keep-button" value="${item.id}">キープ</button>`;
      }
    }

      return `
        <div class="agent-list-item">
          <div class="agent-list-item-header">
            <ul>
              ${item.industry_names.map(industry => `<li>${industry}</li>`).join('')}
              ${item.remote_available ? '<li>リモート可</li>' : ''}
            </ul>
            <div class="agent-list-item-area">${item.area_name}</div>
          </div>
          <div class="agent-list-item-body">
            <div>
              <h3>${item.service_name}
                <a href="${item.service_url}" target="_blank">
                  <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
              </h3>
              <ul class="agent-list-item-features">
                <li>${item.feature1}</li>
                <li>${item.feature2 && item.feature2}</li>
                <li>${item.feature3 && item.feature3}</li>
              </ul>
            </div>
            <div class="agent-list-item-img">
              <img src="./assets/img/service_images/${item.service_image}" alt="">
            </div>
          </div>
          <div class="agent-list-item-footer">
            <p>
              <i class="fa-solid fa-building"></i>
              ${item.company_name}
            </p>
            ${createButton()}
          </div>
        </div>
      `;
    }).join('');

    agentContainer.innerHTML = listHtml;
    startKeepController();

  } else {
    agentContainer.innerHTML = '<p class="not-exits-agent">該当するエージェントは存在しません。</p>';
  }

  createAgentCountDom(data.length, allAgentCount);
}


// キープボタンの処理
const keepCountContainer = document.getElementById('keep-count');

const startKeepController = () => {
  keepButton = document.querySelectorAll('.agent-item-list-button');

  keepButton.forEach(button => {
    button.addEventListener('click', async () => {
      const agentId = Number(button.value);

      if(button.classList.contains('keep-button')) {
        keepAgentsId.push(agentId);
        button.classList.remove('keep-button');
        button.classList.add('lift-button');
        button.innerHTML = '解除';

      } else if(button.classList.contains('lift-button')) {
        const index = keepAgentsId.indexOf(agentId);
        keepAgentsId.splice(index, 1);
        button.classList.remove('lift-button');
        button.classList.add('keep-button');
        button.innerHTML = 'キープ';
      }

      keepCountContainer.innerHTML = keepAgentsId.length;

      const keepIdsInput = document.getElementById('keep-ids-input');
      keepIdsInput.value = keepAgentsId;

      const entryButton = document.getElementById('entry-button');
      if(keepAgentsId.length == 0) {
        entryButton.style.backgroundColor = '#D3D3D3';
        entryButton.disabled = true;
      } else {
        entryButton.style.backgroundColor = '#72CD81';
        entryButton.disabled = false;
      }

      if (!sidebarBody.classList.contains('sidebar-body-open')) {
        sidebarIcon.classList.toggle('sidebar-search-header-icon-open');
        sidebarBody.classList.add('sidebar-body-open');

        const sidebarHeight = sidebarBody.clientHeight;
        if(window.innerWidth >= 768) {
        agentList.style.marginTop = -sidebarHeight - 90 + 'px';
        } else {
        agentList.style.marginTop = -sidebarHeight + 'px';
        }
      }

      if(keepAgentsId.length !== 0) {
        createKeepAgentLinkDom();
      } else if(keepAgentsId.length == 0 && !document.getElementById('keep-link').classList.contains('keep-display-active')) {
        const keepBody = document.getElementById('keep-body');
        keepBody.innerHTML = '<p>キープ中のエージェントは<br>存在しません。</p>';
      }
    })
  })
}


// キープしたエージェントの一覧用リンクを作成
const createKeepAgentLinkDom = () => {
  const keepBody = document.getElementById('keep-body');

  if(keepAgentsId.length !== 0 && !document.getElementById('keep-link')) {
    keepBody.innerHTML = `
    <p class="sidebar-keep-body-link" id="keep-link">キープ中のエージェントを全て<br>確認する</p>
    `;

    const keepLink = document.getElementById('keep-link');
    const agentListHeadline = document.getElementById('agent-list-headline');
    keepLink.addEventListener('click', () => {
      const searchBody = document.getElementById('search-body');

      if(keepLink.classList.contains('keep-display')) {
        searchBody.style.display = 'block';
        if (keepAgentsId.length !== 0) {
          keepLink.innerHTML = 'キープ中のエージェントを全て<br>確認する';
        } else {
          keepBody.innerHTML = `
          <p>キープ中のエージェントは<br>存在しません。</p>
          `;
        }
        keepLink.classList.remove('keep-display-active');
        agentListHeadline.innerHTML = 'エージェント一覧';
        agentListHeadline.style.color = '#000000';
        keepLink.classList.remove('keep-display');

        const sidebarHeight = sidebarBody.clientHeight;
        if(window.innerWidth >= 768) {
        agentList.style.marginTop = -sidebarHeight - 90 + 'px';
        } else {
        agentList.style.marginTop = -sidebarHeight + 'px';
        }

        window.scrollTo(0, 0);

        areaSelectBox.value = 0;
        industrySelectBox.value = 0;
        remoteAvailableCheckbox.checked = false;
        createAgentDom(agentData);

      } else {
        searchBody.style.display = 'none';
        keepLink.innerHTML = '検索画面に戻る';
        keepLink.classList.add('keep-display-active');
        agentListHeadline.innerHTML = 'キープ中のエージェント一覧';
        agentListHeadline.style.color = '#72CD81';
        keepLink.classList.add('keep-display');

        const sidebarHeight = sidebarBody.clientHeight;
        if(window.innerWidth >= 768) {
        agentList.style.marginTop = -sidebarHeight - 90 + 'px';
        } else {
        agentList.style.marginTop = -sidebarHeight + 'px';
        }

        window.scrollTo(0, 0);

        const keepAgentData = agentData.filter(agent => {
          return keepAgentsId.includes(agent.id);
        });
        createAgentDom(keepAgentData);
      }

    })
  } else if(keepAgentsId.length == 0 && document.getElementById('keep-link') && !keepLink.classList.contains('keep-display-active')) {
    keepBody.innerHTML = `
    <p>キープ中のエージェントは<br>存在しません。</p>
    `;
  }
}


// エージェントの件数を表示
const createAgentCountDom = (data, allData) => {
  const agentCount = document.getElementById('agent-count');
  agentCount.innerHTML = `
    <span>${data}/${allData}</span>件
  `;
}


// 絞り込みのセレクトボックスのDOMを生成
const createSelectOptions = (element, data) => {
  const optionsHtml = data.map(item => {
    return `
      <option value="${item.name}">${item.name}</option>
    `;
  }).join('');

  element.insertAdjacentHTML('beforeend', optionsHtml);
}


// 絞り込みのセレクトボックスの値が変更されたら、絞り込みを実行
searchInputs.forEach(input => {
  input.onchange = () => {
    const areaValue = areaSelectBox.value;
    const industryValue = industrySelectBox.value;

    let filteredData = agentData;

    if(areaValue != 0) {
      filteredData = filteredData.filter(item => item.area_name === areaValue || item.area_name === '全国');
    }

    if(industryValue != 0) {
      filteredData = filteredData.filter(item => item.industry_names.includes(industryValue));
    }

    if(remoteAvailableCheckbox.checked) {
      filteredData = filteredData.filter(item => item.remote_available === 1);
    }

    createAgentDom(filteredData);
  };
});

// クリアボタンを押したら、絞り込みを解除
const clearButton = document.getElementById('clear-button');
clearButton.addEventListener('click', () => {
  areaSelectBox.value = 0;
  industrySelectBox.value = 0;
  remoteAvailableCheckbox.checked = false;
  createAgentDom(agentData);
})
