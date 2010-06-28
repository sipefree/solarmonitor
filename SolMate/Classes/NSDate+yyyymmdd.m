//
//  NSDate+yyyymmdd.m
//  SolMate
//
//  Created by Simon Free on 17/06/2010.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "NSDate+yyyymmdd.h"


@implementation NSDate (NSDate_yyyymmdd)
- (int)dateAsYYYYMMDD {
	NSString* desc = [self description];
	NSString* year = [desc substringWithRange:NSMakeRange(0, 4)];
	NSString* month = [desc substringWithRange:NSMakeRange(5, 2)];
	NSString* day = [desc substringWithRange:NSMakeRange(8, 2)];
	NSString* full = [NSString stringWithFormat:@"%@%@%@",year,month,day];
	int retVal = [full intValue];
	return retVal;
}
@end
