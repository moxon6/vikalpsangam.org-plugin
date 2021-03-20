const fs = require('fs');
const archiver = require('archiver');
const ignore = require('./buildignore.json');

const archive = archiver('zip');
archive.pipe(
  fs.createWriteStream(`${__dirname}/vikalpsangam.org-plugin.zip`),
);

archive.glob('**', {
  ignore,
});

archive.finalize();
