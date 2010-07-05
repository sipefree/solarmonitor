//
//  SMPreferences.m
//  SolMate
//
//  Created by Simon Free on 05/07/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "SMPreferences.h"
#import <CoreFoundation/CoreFoundation.h>

#define kSMPreferencesDefaultViewType "defaultViewType"

static SMPreferences* _preferencesInstance;
@implementation SMPreferences
+ (void)initialize {
	_preferencesInstance = nil;
}
- (id)init {
	if(_preferencesInstance != nil)
		return _preferencesInstance;
	else {
		return [super init];
	}
}
+ (SMPreferences*)sharedPreferences {
	@synchronized(self) {
		if(_preferencesInstance == nil) {
			_preferencesInstance = [[SMPreferences alloc] init];
		}
		return _preferencesInstance;
	}
}
- (void)_setValue:(CFStringRef)value forKey:(CFStringRef)key {
	CFPreferencesSetAppValue(key, value, kCFPreferencesCurrentApplication);
	CFPreferencesAppSynchronize(kCFPreferencesCurrentApplication);
}
- (void)setDefaultViewType:(NSString *)type {
	CFStringRef key = CFSTR(kSMPreferencesDefaultViewType);
	CFStringRef value = (CFStringRef)type;
	[self _setValue:value forKey:key];
}
- (NSString*)defaultViewType {
	CFStringRef key = CFSTR(kSMPreferencesDefaultViewType);
	CFStringRef value = (CFStringRef)CFPreferencesCopyAppValue(key, kCFPreferencesCurrentApplication);
	return [(NSString*)value autorelease];
}
@end
