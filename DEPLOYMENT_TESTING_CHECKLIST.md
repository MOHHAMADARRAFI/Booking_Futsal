# ✅ Deployment & Testing Checklist

## 🔧 Pre-Deployment Setup

### Phase 1: Environment Setup
- [ ] Ensure PHP 8.0+ is installed
- [ ] Ensure MySQL 5.7+ is running
- [ ] Ensure Composer is installed
- [ ] Create database: `CREATE DATABASE booking_futsal`

### Phase 2: Laravel Setup
- [ ] Run `composer install`
- [ ] Copy `.env.example` to `.env`
- [ ] Update DB credentials in `.env`:
  ```
  DB_DATABASE=booking_futsal
  DB_USERNAME=root
  DB_PASSWORD=
  ```
- [ ] Run `php artisan key:generate`
- [ ] Run `php artisan migrate`
- [ ] Run `php artisan db:seed`

### Phase 3: Verification
- [ ] Check migrations completed successfully
- [ ] Check seeders created test data
- [ ] Run `php artisan route:list` to verify routes
- [ ] Run `php artisan tinker` to test connection

---

## 🚀 Deployment Checklist

### Before Going Live
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set up proper file permissions
- [ ] Configure SSL/HTTPS certificate
- [ ] Set up email configuration
- [ ] Set up payment gateway credentials

### Database
- [ ] Backup production database regularly
- [ ] Set up proper database backups
- [ ] Verify foreign key constraints
- [ ] Check indexes for performance

### Security
- [ ] Change `APP_KEY` for production
- [ ] Set secure `.env` permissions (chmod 600)
- [ ] Disable `APP_DEBUG` 
- [ ] Configure CORS properly
- [ ] Set up rate limiting
- [ ] Enable HTTPS/SSL

---

## 🧪 Functional Testing

### Authentication Tests
- [ ] Register new account
- [ ] Login with correct credentials
- [ ] Login fails with wrong password
- [ ] Logout functionality works
- [ ] Session expires properly
- [ ] Remember me functionality works

### Customer Functional Tests

#### Browse & Search
- [ ] Homepage loads correctly
- [ ] Can view all active courts
- [ ] Can filter courts by location
- [ ] Can click on court to see details
- [ ] Court details show correct info
- [ ] Reviews display on court detail

#### Booking Process
- [ ] Booking form opens with correct court selected
- [ ] Can select booking date (must be future date)
- [ ] Can select start and end time
- [ ] Price calculates correctly
- [ ] Cannot book past date
- [ ] Cannot book with invalid time range

#### Conflict Detection
- [ ] Cannot book overlapping time slots
- [ ] Cannot book same time as existing booking
- [ ] Error message displays when conflict
- [ ] Can book different time on same day
- [ ] Can book same time different day

#### Payment
- [ ] Payment form displays all methods
- [ ] Can select payment method
- [ ] Payment creates transaction record
- [ ] Booking status changes to "confirmed"
- [ ] Payment status shows "completed"
- [ ] Receipt is accessible

#### Review & Rating
- [ ] Can add review to completed booking
- [ ] Cannot add review to pending booking
- [ ] Can add 1-5 star rating
- [ ] Can write comment
- [ ] Review displays on court page
- [ ] Can edit/delete own review

#### Dashboard
- [ ] Dashboard shows user's bookings
- [ ] Displays upcoming bookings count
- [ ] Displays past bookings
- [ ] Links work correctly

### Owner Functional Tests

#### Court Management
- [ ] Can access owner dashboard
- [ ] Can add new court
- [ ] Can set court name, price, capacity
- [ ] Can upload court image
- [ ] Can view all their courts
- [ ] Can edit their courts
- [ ] Cannot edit other owner's courts
- [ ] Can delete their courts
- [ ] Cannot delete other owner's courts

#### Booking Monitoring
- [ ] Can see all bookings for their courts
- [ ] Can filter by date
- [ ] Can see booking status
- [ ] Can see payment status
- [ ] Dashboard shows accurate revenue
- [ ] Revenue calculation is correct

### Admin Functional Tests

#### Dashboard
- [ ] Can access admin dashboard
- [ ] Dashboard shows total courts
- [ ] Dashboard shows total bookings
- [ ] Dashboard shows total revenue
- [ ] Dashboard shows pending bookings

#### User Management
- [ ] Can view all users
- [ ] Can view user details
- [ ] Can edit user roles
- [ ] Can suspend/activate users
- [ ] Cannot delete admin user

#### Court Management
- [ ] Can view all courts
- [ ] Can edit any court
- [ ] Can delete any court
- [ ] Can change court owner
- [ ] Can activate/deactivate courts

#### Booking Management
- [ ] Can view all bookings
- [ ] Can view booking details
- [ ] Can change booking status
- [ ] Can cancel bookings
- [ ] Cannot create booking (customer only)

#### Payment Management
- [ ] Can view all payments
- [ ] Can see payment methods
- [ ] Can see payment status
- [ ] Can verify transactions
- [ ] Revenue report is accurate

---

## 🔐 Security Testing

### Authentication Security
- [ ] Passwords are hashed (not stored in plain)
- [ ] Cannot access admin routes without admin role
- [ ] Cannot access owner routes without owner role
- [ ] Cannot access customer routes without authentication
- [ ] CSRF tokens are required on forms
- [ ] Cannot forge HTTP method (PUT/DELETE)

### Authorization Security
- [ ] Owner cannot view other owner's courts
- [ ] Customer cannot view other customer's bookings
- [ ] Customer cannot access admin panel
- [ ] Admin cannot be deleted by others
- [ ] Cannot manually change URL to access forbidden areas

### Data Validation
- [ ] Cannot submit empty required fields
- [ ] Cannot enter negative prices
- [ ] Cannot enter invalid email formats
- [ ] Cannot enter past dates for booking
- [ ] Cannot submit overlapping time slots
- [ ] SQL injection attempts are prevented
- [ ] XSS attempts are prevented

---

## 📊 Performance Testing

### Load Testing
- [ ] Homepage loads in < 2 seconds
- [ ] Court listing loads in < 3 seconds
- [ ] Dashboard loads in < 2 seconds
- [ ] Booking form loads in < 2 seconds
- [ ] Can handle 100 concurrent users
- [ ] No memory leaks over time

### Database Performance
- [ ] Queries complete in < 500ms
- [ ] Indexes are properly set up
- [ ] No N+1 query problems
- [ ] Eager loading is used
- [ ] Pagination works with large datasets

---

## 📱 UI/UX Testing

### Desktop Testing
- [ ] All pages render correctly
- [ ] Navigation works smoothly
- [ ] Forms are user-friendly
- [ ] Error messages are clear
- [ ] Success messages display
- [ ] Buttons are clickable

### Mobile Testing
- [ ] Responsive design works
- [ ] Mobile navigation works
- [ ] Touch interactions work
- [ ] Forms are mobile-friendly
- [ ] Images resize properly
- [ ] No horizontal scrolling

### Cross-Browser Testing
- [ ] Works in Chrome
- [ ] Works in Firefox
- [ ] Works in Safari
- [ ] Works in Edge
- [ ] No console errors

---

## 📝 Regression Testing

### After Updates/Changes
- [ ] Run full test suite
- [ ] Test all CRUD operations
- [ ] Test all user roles
- [ ] Test all business logic
- [ ] Verify no new bugs
- [ ] Performance is maintained

---

## 🐛 Bug Tracking

### Found Issues
- [ ] Log bug details
- [ ] Record steps to reproduce
- [ ] Note expected vs actual behavior
- [ ] Check if it's environment-specific
- [ ] Assign priority level
- [ ] Track resolution

### Common Issues & Fixes

| Issue | Cause | Fix |
|-------|-------|-----|
| Database connection error | MySQL not running | Start MySQL service |
| Migration error | Foreign key constraint | Ensure tables exist in order |
| View not found | Wrong view path | Check resources/views path |
| Route not found | Routes not registered | Run `php artisan route:list` |
| 404 on static files | Assets not cached | Run `php artisan view:clear` |
| Middleware not working | Not registered in Kernel | Check app/Http/Kernel.php |

---

## 📊 Testing Summary Template

```
Testing Date: _______________
Version: _______________
Environment: _______________
Tester: _______________

Total Test Cases: ___
Passed: ___
Failed: ___
Blocked: ___

Critical Issues: ___
High Priority: ___
Medium Priority: ___
Low Priority: ___

Notes:
_________________________________
_________________________________
_________________________________

Signed: _______________
```

---

## ✨ Post-Deployment

### Monitor
- [ ] Monitor error logs
- [ ] Monitor performance metrics
- [ ] Monitor user activity
- [ ] Monitor database size
- [ ] Monitor disk space

### Maintain
- [ ] Regular database backups
- [ ] Regular security updates
- [ ] Regular code reviews
- [ ] Regular performance audits
- [ ] Regular user support

### Improve
- [ ] Collect user feedback
- [ ] Monitor usage patterns
- [ ] Identify bottlenecks
- [ ] Plan enhancements
- [ ] Plan optimizations

---

## 🎯 Go-Live Checklist

Final Sign-Off:
- [ ] All tests passed
- [ ] No critical bugs
- [ ] Documentation complete
- [ ] Team trained
- [ ] Support ready
- [ ] Backup configured
- [ ] Monitoring active
- [ ] Performance acceptable
- [ ] Security validated
- [ ] Client approved

**Status: Ready for Production ✅**

---

**Testing completed by:** _____________
**Date:** _____________
**Approved by:** _____________

---

## 📞 Support Contacts

- **Technical Support:** [support contact]
- **Admin Contact:** [admin contact]
- **Emergency Contact:** [emergency contact]

---

*Last Updated: 2024*
*System: Sistem Penyewaan Lapangan Futsal*
