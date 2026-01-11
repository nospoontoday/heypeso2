# Coding Rules

## Time Usage Rule
Whenever creating or fixing code in this project, **always use the `time_now()` helper function instead of `now()` or `Carbon::now()`** for any business logic timestamps. This ensures consistency with the time manipulation feature for testing purposes.

### Examples:
- ✅ `$user->created_at = time_now();`
- ❌ `$user->created_at = now();`
- ✅ `$expires_at = time_now()->addDays(30);`
- ❌ `$expires_at = Carbon::now()->addDays(30);`

### Exceptions:
- System-level logging, caching, or framework internals may continue using `now()` if not affecting business logic.
- Database migrations and seeds should use real time.

This rule applies to all code modifications, new features, and bug fixes.