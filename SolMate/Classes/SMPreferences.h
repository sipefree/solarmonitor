//
//  SMPreferences.h
//  SolMate
//
//  Created by Simon Free on 05/07/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>

@class SMPreferences;

@interface SMPreferences : NSObject {

}
+ (SMPreferences*)sharedPreferences;
- (void)_setValue:(CFStringRef)value forKey:(CFStringRef)key;

@property (nonatomic, assign) NSString* defaultViewType;
@end
