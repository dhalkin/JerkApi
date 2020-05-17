#!/usr/bin/env bash

# trace ERR through pipes
set -o pipefail

# trace ERR through 'time command' and other functions
set -o errtrace

# set -u : exit the script if you try to use an uninitialised variable
set -o nounset

# set -e : exit the script if any statement returns a non-true return value
set -o errexit

apt autoremove -y 2&>1 >/dev/null || true
apt clean -y 2&>1 >/dev/null || true
apt autoclean -y 2&>1 >/dev/null || true

rm -rf \
	/app/storage/framework/views/* \
	/app/storage/app/public/* \
	/app/storage/logs/* \
	/app/storage/framework/cache/* \
	/var/lib/apt/lists/* \
	/tmp/* \
	/var/tmp/* \
	/var/cache \
	/etc/nginx/sites-enabled/default \
	/etc/nginx/conf.d/nginx_status_location \
	/usr/lib/php/20121212 \
	/usr/lib/php/20131226

find /var/log -type f | while read f; do
	echo -ne '' > ${f} 2&>1 > /dev/null || true;
done

# The for loop throws an error in case of absence file.
# Thus we'll use if-condition here.
# Note: We don't use recursive search.
if [ -z "$(find /entrypoint.d -maxdepth 1 -type f  -name \"*.sh\" 2>/dev/null)" ]; then
    for file in /entrypoint.d/*.sh; do
    	chmod +x ${file} || true;
    done
fi

mkdir -p /var/cache/apt
mkdir /var/tmp/nginx

exit 0
