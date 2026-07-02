#!/bin/bash
echo "Iniciando servidor com limites de upload aumentados (100MB)..."
php -d upload_max_filesize=100M -d post_max_size=105M -d memory_limit=512M artisan serve "$@"
