git config --global user.name "c00cjz00"
git config --global user.email summerhill001@gmail.com
#git pull
git checkout master
git rm crontab-crontab.php crontab-sftp.php run_Filezilla.bat autoFileZilla.php 
git rm -r FileZillaPortable
git add *
git commit -m "init"
# 上傳至遠端
git push origin master

