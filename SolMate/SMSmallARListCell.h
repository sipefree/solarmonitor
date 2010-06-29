//
//  SMSmallARListCell.h
//
//  Created by Simon Free on 08/06/2010.
//  Copyright 2010 SolarMonitor.org. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <Foundation/Foundation.h>

@interface SMSmallARListCell : UITableViewCell {
    IBOutlet UILabel* label;
}
@property (readonly) UILabel* label;
@end
