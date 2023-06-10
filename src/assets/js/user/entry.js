'use strict';

const entryForm = document.getElementById('entry-form');
const entryButton = document.getElementById('entry-send-button');
let submitFlag = false;

entryForm.addEventListener('submit', (e) => {
  if (!submitFlag) {
    entryButton.disabled = true;
    submitFlag = true;
  } else {
    return false;
  }
});
