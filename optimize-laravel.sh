#!/bin/bash

# ╔══════════════════════════════════════════════════════════════════════════════╗
# ║           LARAVEL OPTIMIZATION SCRIPT - Production Ready                     ║
# ║           Optimizes your Laravel application for maximum performance         ║
# ╚══════════════════════════════════════════════════════════════════════════════╝

set -e # Exit on error

echo "🚀 Starting Laravel Optimization Process..."
echo "=================================================="

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored messages
print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

# Check if we're in a Laravel project
if [ ! -f "artisan" ]; then
    print_error "Error: artisan file not found. Are you in a Laravel project directory?"
    exit 1
fi

print_success "Laravel project detected"

# ============================================
# STEP 1: Clear All Caches
# ============================================
echo ""
echo "📦 Step 1: Clearing all existing caches..."

php artisan cache:clear && print_success "Application cache cleared" || print_warning "Failed to clear application cache"
php artisan config:clear && print_success "Config cache cleared" || print_warning "Failed to clear config cache"
php artisan route:clear && print_success "Route cache cleared" || print_warning "Failed to clear route cache"
php artisan view:clear && print_success "View cache cleared" || print_warning "Failed to clear view cache"
php artisan event:clear && print_success "Event cache cleared" || print_warning "Failed to clear event cache"

# ============================================
# STEP 2: Optimize Composer Autoloader
# ============================================
echo ""
echo "📚 Step 2: Optimizing Composer autoloader..."

if command -v composer &> /dev/null; then
    composer dump-autoload --optimize && print_success "Composer autoloader optimized"
else
    print_warning "Composer not found, skipping autoloader optimization"
fi

# ============================================
# STEP 3: Cache Configuration
# ============================================
echo ""
echo "⚙️  Step 3: Caching configuration..."

php artisan config:cache && print_success "Configuration cached" || print_error "Failed to cache configuration"

# ============================================
# STEP 4: Cache Routes
# ============================================
echo ""
echo "🛣️  Step 4: Caching routes..."

php artisan route:cache && print_success "Routes cached" || print_warning "Failed to cache routes (check for closures in routes)"

# ============================================
# STEP 5: Cache Views
# ============================================
echo ""
echo "👁️  Step 5: Caching views..."

php artisan view:cache && print_success "Views cached" || print_warning "Failed to cache views (check for syntax errors)"

# ============================================
# STEP 6: Cache Events
# ============================================
echo ""
echo "📡 Step 6: Caching events..."

php artisan event:cache && print_success "Events cached" || print_warning "Failed to cache events"

# ============================================
# STEP 7: Optimize Assets (if Vite/Mix exists)
# ============================================
echo ""
echo "🎨 Step 7: Optimizing assets..."

if [ -f "vite.config.js" ]; then
    if command -v npm &> /dev/null; then
        npm run build && print_success "Vite assets built and optimized"
    else
        print_warning "npm not found, skipping asset optimization"
    fi
elif [ -f "webpack.mix.js" ]; then
    if command -v npm &> /dev/null; then
        npm run production && print_success "Mix assets built and optimized"
    else
        print_warning "npm not found, skipping asset optimization"
    fi
else
    print_warning "No asset bundler detected (Vite/Mix), skipping"
fi

# ============================================
# STEP 8: Database Optimization (Optional)
# ============================================
echo ""
echo "🗄️  Step 8: Database optimization..."

read -p "Run database migrations? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate --force && print_success "Migrations completed"
fi

read -p "Optimize database tables? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan db:optimize && print_success "Database optimized" || print_warning "Database optimization not available"
fi

# ============================================
# STEP 9: Queue Workers (Optional)
# ============================================
echo ""
echo "⚡ Step 9: Queue management..."

read -p "Restart queue workers? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan queue:restart && print_success "Queue workers restarted"
fi

# ============================================
# STEP 10: Create Symlink for Storage
# ============================================
echo ""
echo "🔗 Step 10: Creating storage symlink..."

if [ ! -L "public/storage" ]; then
    php artisan storage:link && print_success "Storage symlink created"
else
    print_warning "Storage symlink already exists"
fi

# ============================================
# STEP 11: File Permissions
# ============================================
echo ""
echo "🔐 Step 11: Setting file permissions..."

chmod -R 755 storage bootstrap/cache && print_success "Permissions set for storage and bootstrap/cache"

# ============================================
# STEP 12: Generate Application Key (if not set)
# ============================================
echo ""
echo "🔑 Step 12: Checking application key..."

if grep -q "APP_KEY=$" .env 2>/dev/null; then
    print_warning "Application key not set, generating..."
    php artisan key:generate && print_success "Application key generated"
else
    print_success "Application key already set"
fi

# ============================================
# SUMMARY & RECOMMENDATIONS
# ============================================
echo ""
echo "=================================================="
echo "✨ Optimization Complete! ✨"
echo "=================================================="
echo ""
echo "📊 Summary:"
echo "  ✓ All caches cleared and rebuilt"
echo "  ✓ Composer autoloader optimized"
echo "  ✓ Assets built (if applicable)"
echo "  ✓ Permissions configured"
echo ""
echo "🎯 Additional Recommendations:"
echo ""
echo "1. Enable OPcache in php.ini:"
echo "   opcache.enable=1"
echo "   opcache.memory_consumption=256"
echo "   opcache.interned_strings_buffer=16"
echo "   opcache.max_accelerated_files=10000"
echo ""
echo "2. Use Redis for caching (update .env):"
echo "   CACHE_DRIVER=redis"
echo "   SESSION_DRIVER=redis"
echo "   QUEUE_CONNECTION=redis"
echo ""
echo "3. Configure your web server (Nginx/Apache):"
echo "   - Enable Gzip compression"
echo "   - Set cache headers for static assets"
echo "   - Use HTTP/2"
echo ""
echo "4. Monitor performance with:"
echo "   - Laravel Telescope (dev/staging)"
echo "   - Laravel Debugbar (dev only)"
echo "   - APM tools (production)"
echo ""
echo "5. Database optimization:"
echo "   - Add indexes to frequently queried columns"
echo "   - Use query caching"
echo "   - Implement eager loading"
echo ""
echo "6. Test your site speed:"
echo "   - Google PageSpeed Insights"
echo "   - GTmetrix"
echo "   - Pingdom"
echo ""
echo "📝 Next Steps:"
echo "  1. Test your application: php artisan serve"
echo "  2. Check for errors in storage/logs/laravel.log"
echo "  3. Monitor performance improvements"
echo "  4. Set up a cron job for scheduled tasks"
echo ""
echo "🔄 To run this optimization again:"
echo "  chmod +x optimize-laravel.sh"
echo "  ./optimize-laravel.sh"
echo ""
echo "=================================================="
echo "Happy coding! 🚀"
echo "=================================================="

# ============================================
# OPTIONAL: Create systemd service for queue
# ============================================
echo ""
read -p "Create queue worker systemd service? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    cat > /tmp/laravel-worker.service << EOF
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php $(pwd)/artisan queue:work --sleep=3 --tries=3 --max-time=3600

[Install]
WantedBy=multi-user.target
EOF
    
    print_success "Service file created at /tmp/laravel-worker.service"
    echo "To install:"
    echo "  sudo mv /tmp/laravel-worker.service /etc/systemd/system/"
    echo "  sudo systemctl daemon-reload"
    echo "  sudo systemctl enable laravel-worker"
    echo "  sudo systemctl start laravel-worker"
fi

# ============================================
# OPTIONAL: Create deployment script
# ============================================
echo ""
read -p "Create deployment script? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    cat > deploy.sh << 'EOF'
#!/bin/bash
# Laravel Deployment Script

set -e

echo "🚀 Deploying Laravel Application..."

# Pull latest changes
git pull origin main

# Install/update dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Run optimizations
php artisan down
php artisan migrate --force
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:restart
php artisan up

# Build assets
npm ci
npm run build

echo "✅ Deployment complete!"
EOF
    
    chmod +x deploy.sh
    print_success "Deployment script created: deploy.sh"
fi

echo ""
print_success "All done! Your Laravel application is now optimized! 🎉"