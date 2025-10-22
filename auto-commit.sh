commit_message="Auto-commit du $(date '+%d/%m/%Y à %H:%M:%S')"
git add .
git commit -m "$cillit_message"
git push origin main
echo " Commit et push effectués avec succès : $commit_message"
