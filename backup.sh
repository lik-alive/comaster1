echo 'comaster1 backup started'
ROOT=$1/comaster1
mkdir $ROOT

# Backup web files
WEBPATH=$ROOT/web
mkdir $WEBPATH
rsync -a . $WEBPATH --exclude .git

# Backup db
DBPATH=$ROOT/db
mkdir $DBPATH
mysqldump -u$2 -p$3 --databases co1db > $DBPATH/dump.sql
echo 'comaster1 backup finished'