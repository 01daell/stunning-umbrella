#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
OUTPUT_DIR="${ROOT_DIR}/dist"
RELEASE_NAME="studiokit-release"

rm -rf "${OUTPUT_DIR}"
mkdir -p "${OUTPUT_DIR}/${RELEASE_NAME}"

rsync -a \
  --exclude ".git" \
  --exclude "node_modules" \
  --exclude "storage/logs" \
  --exclude "storage/framework/cache" \
  --exclude "storage/framework/sessions" \
  --exclude "storage/framework/views" \
  --exclude "dist" \
  "${ROOT_DIR}/" "${OUTPUT_DIR}/${RELEASE_NAME}/"

if [[ ! -d "${OUTPUT_DIR}/${RELEASE_NAME}/vendor" ]]; then
  echo "Vendor directory missing. Run composer install before building the release." >&2
  exit 1
fi

(cd "${OUTPUT_DIR}" && zip -r "${RELEASE_NAME}.zip" "${RELEASE_NAME}")

echo "Release bundle created at ${OUTPUT_DIR}/${RELEASE_NAME}.zip"
